#!/usr/bin/env python3
"""Exercise the public HTTP boundary against a running Compose stack."""
import http.client
import os
import unittest

PORT = int(os.environ.get("HTTP_PORT", "8080"))


def request(host, path="/"):
    connection = http.client.HTTPConnection("127.0.0.1", PORT, timeout=5)
    try:
        connection.request("GET", path, headers={"Host": host})
        response = connection.getresponse()
        return response.status, dict(response.getheaders()), response.read().decode()
    finally:
        connection.close()


class MultisiteTests(unittest.TestCase):
    def test_hosts_route_to_distinct_applications(self):
        for host, expected, excluded in [
            ("site-one.localhost", "Fieldnotes", "Papertrail"),
            ("site-two.localhost", "Papertrail", "Fieldnotes"),
        ]:
            with self.subTest(host=host):
                status, headers, body = request(host)
                self.assertEqual(status, 200)
                self.assertIn(expected, body)
                self.assertNotIn(excluded, body)
                self.assertNotIn("X-Powered-By", headers)
                self.assertEqual(headers["X-Content-Type-Options"], "nosniff")
                self.assertIn("frame-ancestors 'none'", headers["Content-Security-Policy"])

    def test_unknown_hosts_do_not_leak_a_site(self):
        self.assertEqual(request("unknown.invalid")[0], 404)

    def test_private_and_nonexistent_files_are_not_served(self):
        for host in ("site-one.localhost", "site-two.localhost"):
            for path in ("/.env", "/.git/config", "/missing.php", "/missing", "/index.php/extra"):
                with self.subTest(host=host, path=path):
                    self.assertIn(request(host, path)[0], (403, 404))

    def test_liveness_endpoint(self):
        self.assertEqual(request("localhost", "/healthz")[::2], (200, "healthy\n"))

    def test_stylesheet_and_accessible_page_structure(self):
        status, _, css = request("site-one.localhost", "/assets/app.css")
        self.assertEqual(status, 200)
        self.assertIn("@media", css)
        body = request("site-one.localhost")[2]
        self.assertIn('name="viewport"', body)
        self.assertIn('<main id="main">', body)
        self.assertNotIn("phpinfo()", body)


if __name__ == "__main__":
    unittest.main(verbosity=2)
