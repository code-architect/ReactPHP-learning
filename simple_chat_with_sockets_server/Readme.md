## Server info [Sockets - Server]
- Start with a loop
- Then create a service socket, it requires an IP address with a port number and a loop
- Now when the loop runs the socket immediately starts listening to incoming connections
[**Our socket is an event emitter, that means we can attach handler for certain events and 
performs action when these events occurs**]
- When a new connection arrives the server fires a ``connection`` event. And a handler for this event accepts an instance 
of the incoming connection.

### Asynchronous PHP Chat
1. First we need to store our active connections. It will be a pool. Connections will be stored in a ``SplObjectStorage``.
Consider it as a map from objects to data. (step 1)

2. There will be one public method ``add``. When a new connection arrives, it will be passed into this method. (step 2)

3.  Then we attach this connection to the pool and register some event handlers. when a new data comes, we send send all 
active connections in our pool except the current one. (step 3)

4. In a callback we loop through already stored connections and write the receive data to them. (step 4)

5. We don't want to store connections endlessly, so when the client close the chat we should detach the connection from 
the pool. (step 5)

6. Updating the ``server.php``. Create a pool. (step 6)

7. Pass it inside the connection callback, then add incoming connection. (step 7)

8. When new user arrives, will receive a message excepts current one. (step 8)



 