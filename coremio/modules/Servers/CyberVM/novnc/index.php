<?php session_start();

    $host       = isset($_SESSION["vnc_host"]) ? $_SESSION["vnc_host"] : false;
    $port       = isset($_SESSION["vnc_port"]) ? $_SESSION["vnc_port"] : false;
    $password   = isset($_SESSION["vnc_password"]) ? $_SESSION["vnc_password"] : false;

    if(!$host || !$port || !$password) die("Authorization failed!");

    function isSSL(){
        if((isset($_SERVER['https']) && $_SERVER['https'] == 'on') || (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER["HTTP_SSL"]) && $_SERVER["HTTP_SSL"] == "TRUE"))
            return true;
        elseif(isset($_SERVER['HTTP_X_FORWARDED_PORT']) && $_SERVER['HTTP_X_FORWARDED_PORT'] == '443')
            return true;
        elseif(!empty( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' )
            return true;

        return false;
    }

    if(isSSL()){
        header("Location: http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);
        exit;
    }
?>
<!DOCTYPE html>
<html>
<head>

    <!--
    noVNC example: lightweight example using minimal UI and features

    This is a self-contained file which doesn't import WebUtil or external CSS.

    Copyright (C) 2018 The noVNC Authors
    noVNC is licensed under the MPL 2.0 (see LICENSE.txt)
    This file is licensed under the 2-Clause BSD license (see LICENSE.txt).

    Connect parameters are provided in query string:
        http://example.com/?host=HOST&port=PORT&scale=true
    -->
    <title>noVNC</title>

    <meta charset="utf-8">

    <!-- Always force latest IE rendering engine (even in intranet) &
        Chrome Frame. Remove this if you use the .htaccess -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <style type="text/css">

        body {
            margin: 0;
            background-color: dimgrey;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        html {
            height: 100%;
        }

        #top_bar {
            background-color: #6e84a3;
            color: white;
            font: bold 12px Helvetica;
            padding: 6px 5px 4px 5px;
            border-bottom: 1px outset;
        }
        #status {
            text-align: center;
        }
        #sendCtrlAltDelButton {
            position: fixed;
            top: 0px;
            right: 0px;
            border: 1px outset;
            padding: 5px 5px 4px 5px;
            cursor: pointer;
        }

        #screen {
            flex: 1; /* fill remaining space */
            overflow: hidden;
        }

    </style>

    <!-- Promise polyfill for IE11 -->
    <script src="vendor/promise.js"></script>

    <!-- ES2015/ES6 modules polyfill -->
    <script type="module">
        window._noVNC_has_module_support = true;
    </script>
    <script>
        window.addEventListener("load", function() {
            if (window._noVNC_has_module_support) return;
            const loader = document.createElement("script");
            loader.src = "vendor/browser-es-module-loader/dist/" +
                "browser-es-module-loader.js";
            document.head.appendChild(loader);
        });
    </script>

    <!-- actual script modules -->
    <script type="module" crossorigin="anonymous">
        // RFB holds the API to connect and communicate with a VNC server
        import RFB from './core/rfb.js';

        let rfb;
        let desktopName;

        // When this function is called we have
        // successfully connected to a server
        function connectedToServer(e) {
            status("Connected to " + desktopName);
        }

        // This function is called when we are disconnected
        function disconnectedFromServer(e) {
            if (e.detail.clean) {
                status("Disconnected");
            } else {
                status("Something went wrong, connection is closed");
            }
        }

        // When this function is called, the server requires
        // credentials to authenticate
        function credentialsAreRequired(e) {
            const password = prompt("Password Required:");
            rfb.sendCredentials({ password: password });
        }

        // When this function is called we have received
        // a desktop name from the server
        function updateDesktopName(e) {
            desktopName = e.detail.name;
        }

        // Since most operating systems will catch Ctrl+Alt+Del
        // before they get a chance to be intercepted by the browser,
        // we provide a way to emulate this key sequence.
        function sendCtrlAltDel() {
            rfb.sendCtrlAltDel();
            return false;
        }

        // Show a status text in the top bar
        function status(text) {
            document.getElementById('status').textContent = text;
        }

        // This function extracts the value of one variable from the
        // query string. If the variable isn't defined in the URL
        // it returns the default value instead.
        function readQueryVariable(name, defaultValue) {
            // A URL with a query parameter can look like this:
            // https://www.example.com?myqueryparam=myvalue
            //
            // Note that we use location.href instead of location.search
            // because Firefox < 53 has a bug w.r.t location.search
            const re = new RegExp('.*[?&]' + name + '=([^&#]*)'),
                match = document.location.href.match(re);
            if (typeof defaultValue === 'undefined') { defaultValue = null; }

            if (match) {
                // We have to decode the URL since want the cleartext value
                return decodeURIComponent(match[1]);
            }

            return defaultValue;
        }

        document.getElementById('sendCtrlAltDelButton')
            .onclick = sendCtrlAltDel;

        // Read parameters specified in the URL query string
        // By default, use the host and port of server that served this file
        const host = readQueryVariable('host', '<?php echo $host; ?>');
        let port = readQueryVariable('port', '<?php echo $port; ?>');
        const password = readQueryVariable('password', '<?php echo $password; ?>');
        const path = readQueryVariable('path', 'websockify?token=<?php echo md5($password); ?>');

        // | | |         | | |
        // | | | Connect | | |
        // v v v         v v v

        status("Connecting");

        // Build the websocket URL used to connect
        let url;
        if (window.location.protocol === "https:") {
            url = 'wss';
        } else {
            url = 'ws';
        }
        url += '://' + host;
        if(port) {
            url += ':' + port;
        }
        url += '/' + path;

        // Creating a new RFB object will start a new connection
        rfb = new RFB(document.getElementById('screen'), url,
            { credentials: { password: password } });

        // Add listeners to important events from the RFB module
        rfb.addEventListener("connect",  connectedToServer);
        rfb.addEventListener("disconnect", disconnectedFromServer);
        rfb.addEventListener("credentialsrequired", credentialsAreRequired);
        rfb.addEventListener("desktopname", updateDesktopName);

        // Set parameters that can be changed on an active connection
        rfb.viewOnly = readQueryVariable('view_only', false);
        rfb.scaleViewport = readQueryVariable('scale', false);
    </script>
</head>

<body>
<div id="top_bar">
    <div id="status">Loading</div>
    <div id="sendCtrlAltDelButton">Send Ctrl + Alt + Del</div>
</div>
<div id="screen">
    <!-- This is where the remote screen will appear -->
</div>
</body>
</html>