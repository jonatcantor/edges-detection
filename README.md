Realtime image processing for edges detection between client and server.
Using [Web Socket protocol](https://en.wikipedia.org/wiki/WebSocket).

A learning project that uses [JS as Client](https://developer.mozilla.org/en-US/docs/Web/JavaScript) and [PHP as Server](https://www.php.net/manual/en).

# How it work
The video from camera is rendered in realtime on canvas, each frame of video is geted and sent to the server to be processed.
Once the server has processed the image, it returns the image to the client.
The client sent a new image of next frame video and render the image recived by the server.

# Run in local environment
The access to camera and audio only is possible from [HTTPS](https://en.wikipedia.org/wiki/HTTPS).

In local environments if you do not use HTTPS, you must configurate the browser from which you want to access the app to 'treat the insecure origin as secure' (only the local origin, where you will execute the client) so you can use the camera and audio in HTTP.

In Chrome is very simple [configure it](https://stackoverflow.com/questions/40696280/unsafely-treat-insecure-origin-as-secure-flag-is-not-working-on-chrome).

Then clone the repository
```

git clone git@github.com:jonatcantor/edges-detection.git

```

Access the created project folder and install the necessary dependencies for [React](https://reactjs.org)
```

cd edges-detection
yarn install

```

Access the 'php' folder and install the necessary dependencies of [Composer](https://getcomposer.org)
```

cd php
composer install

```

Edit the .env files in root folder for React, and 'php' folder for PHP execution. Use the same local ip adress and port for the both files.

You can open the project from root folder with [VS Code](https://code.visualstudio.com) and edit the .env files.

The .env.example files are example files, you must to create .env files for each .env.example file so it work.
```

cd ..
code .

```

Then inside of 'php' folder you initialize the Web Socket server from php
```

cd php
php -q Main.php

```

Open another terminal in root folder and you initialize the React app
```

yarn start

```

Now try to access the app in your mobile or pc browser (you must give permissions to access the camera for it to work)!

If you use another device to connect to your local network, remember to give permissions to the firewall or disable it to allow the connection.
