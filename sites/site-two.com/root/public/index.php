<?php
declare(strict_types=1);
// Only expose a controlled runtime summary, never environment variables or phpinfo.
$runtime = htmlspecialchars(PHP_MAJOR_VERSION . '.' . PHP_MINOR_VERSION, ENT_QUOTES, 'UTF-8');
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="A working example of isolated PHP applications behind a shared NGINX gateway.">
        <title>
            Papertrail · PHP Multisite
        </title>
        <link rel="stylesheet" href="/assets/app.css">
    </head>
    <body class="papertrail">
        <a class="skip" href="#main">
            Skip to content
        </a>
        <header>
            <div class="brand">
                <span>
                    P
                </span>
                Papertrail
            </div>
            <a href="https://github.com/Pablo-Camara/simple-multi-site-docker-compose-nginx-alpine-php-fpm-alpine-https-ssl-certificates">
                View the stack on GitHub
            </a>
        </header>
        <main id="main">
            <div class="hero">
                <div>
                    <h1>
                        Make room for the work that matters.
                    </h1>
                    <p class="intro">
                        One of two independent sites, served by a single NGINX gateway. A small, working example of a well-defined boundary.
                    </p>
                    <div class="state">
                        <span class="dot" aria-hidden="true">
                        </span>
                        PHP request served successfully
                    </div>
                </div>
                <div class="illustration">
                    <div class="browser">
                        <div class="browserbar">
                            <i>
                            </i>
                            <i>
                            </i>
                            <i>
                            </i>
                            <span>
                                site-two.localhost
                            </span>
                        </div>
                        <div class="sheet">
                            <h2>
                                Your workspace
                            </h2>
                            <p>
                                Sample content. No accounts or personal data.
                            </p>
                            <div class="entry">
                                <b>
                                    1
                                </b>
                                Project brief
                                <span>
                                    Demo
                                </span>
                            </div>
                            <div class="entry">
                                <b>
                                    2
                                </b>
                                Design decisions
                                <span>
                                    Demo
                                </span>
                            </div>
                            <div class="entry">
                                <b>
                                    3
                                </b>
                                Delivery notes
                                <span>
                                    Demo
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="details">
                <section>
                    <h2>
                        A runtime of its own
                    </h2>
                    <p>
                        This application has its own PHP-FPM worker and source mount.
                    </p>
                </section>
                <section>
                    <h2>
                        A shared front door
                    </h2>
                    <p>
                        NGINX routes each hostname to the right application.
                    </p>
                </section>
                <section>
                    <h2>
                        Simple to inspect
                    </h2>
                    <p>
                        Health checks, bounded resources and readable configuration.
                    </p>
                </section>
            </div>
            <div class="runtime">
                <span>
                    PHP
                    <?= $runtime ?>
                    · NGINX · Docker Compose
                </span>
                <code>
                    site-two.localhost
                </code>
            </div>
        </main>
        <footer>
            This is a demonstration page for PHP Multisite. The workspace above is illustrative.
        </footer>
    </body>
</html>
