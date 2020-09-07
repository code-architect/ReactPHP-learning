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

9. **Note: *_Remember ```SplObjectStorage``` is a map between object and data. Out case data will be a users name._***

10. So we cannot use ```attach()``` and ```detach()``` methods. Instead we will use connect object as offset keys. We add two
additional methods. ```getConnectionName()``` and ```setConnectionName()```. Pass the ConnectionInterface.

11. **Editing code on line of step 3:** When a new user arrives ask for user name, and store it or set it with an empty
 name. (step 9 & 10)

12. Then next time data from this connection we check if we have a name associated with it we consider it as a message. 
But if this connection dose not have a stored name, we store the data name. (step 11)

13. **Editing code on line of step 4:** Updating this chat notification with a username

14. **Editing code on line of step 5:** Removing the connection when it closes. Again first we get the name for this 
connection, then remove it, then send a notification.



 