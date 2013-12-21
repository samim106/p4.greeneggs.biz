p4.greeneggs.biz
================

project 4

This application builds from P2. I have started from scratch and installed everything needed to re-learn the process of putting together the DB & configuring the environment & base files. It was a good learning experience again. 

I've extended P2 by changing all of the previous forms and links to use AJAX to call back to the server. This also includes giving the user status on the submissions they make. I've also included a messaging area where users can chat with each other. Simple form checking is also in my chat area to confirm each message is <144 characters. Users can also view their previous posts. 

I attempted to do private messsaging from client to client but ran out of time. If you look at:
- js/msgs.js
- js/msgs_private.js
- controllers/c_msgs_private.php 
- views/v_msgs_private.php
that's where I was trying to pop up windows based on who was receiving the message. The windows were created dynamically by clicking on the username, but I didn't have enough time to open a window on the receiver's end. It's not part of my project, but I just thought I'd mention it since I really wanted to make it work and will work on it when I find more time.

The account I've been using is user: test@test.com and pw: test. Feel free to create your own account as well. 