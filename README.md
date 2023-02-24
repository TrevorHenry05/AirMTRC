# AirMTRC
A web interface to interact with a property rental database that stores users, properties , and rentals.
![GitHub Logo](/images/airmtrc.PNG) 

Deployed on the Google Cloud Platform using a virtual machine **Lamp packaged by Bitnami**. Database was deployed using phpmyadmin and web interface deployed using ICEcoder on the virtual machine.

The login screen allows already registered users to login, while the registration page enables new users to sign up for an account. After successfully logging in, you will be directed to the Dashboard, which is the main page of our project.
![GitHub Logo](/images/index.PNG)
![GitHub Logo](/images/register.PNG)

The Dashboard is the main page of our project, featuring a navigation bar at the top that allows you to switch between pages. Here, you will also find an introduction to the project, including the names and contact information of our group members.
![GitHub Logo](/images/dashboard.PNG)

After clicking on the "Search" link in the navigation bar, you will be directed to a page where you can select a state and/or city to search for properties. Once you've made your selection(s), click the "Submit" button, and the page will display a table of properties in the selected location(s) below. You can select one of the results to rent it.
![GitHub Logo](/images/search.PNG) 

Upon clicking the "Search Price" link in the navigation bar, you will be directed to a page where you can specify your search criteria by entering a minimum and/or maximum price, as well as selecting a type of rental (short-term or long-term). Once you've entered your criteria, the page will display a table of properties that meet your search requirements below. You can select one of the results to rent it.
![GitHub Logo](/images/searchprice.PNG)

When you're on either of the search results page, you can select a property from the list of result of your search and click on it to be taken to a rental form page. From there, you can proceed to rent the property, and the system will automatically insert the rental information into the database. Additionally, an invoice for the rental will be created, which can be viewed on your user profile.
![GitHub Logo](/images/rental.PNG)

After clicking on the "Profile" link in the navigation bar, you will be directed to a page displaying the current user's name and email at the top. The page will also feature two buttons: "User Rentals" and "User Properties". Clicking on "User Rentals" will display a table of all rentals made by the current user, while clicking on "User Properties" will show a list of properties posted by the user.
![GitHub Logo](/images/profile.PNG)

After navigating to the "Post" link in the navigation bar, you will be redirected to a user-friendly form where you can easily fill out all the necessary details of your property. Our platform ensures that the form is intuitive and easy to use, so you can quickly and accurately post your property without any hassle.

Once you have filled out all the required fields, you can confidently hit the "submit" button, and our platform will automatically process your submission. The property will be hosted by the current user logged in.
![GitHub Logo](/images/post.PNG)





