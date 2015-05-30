<h2>About</h2>

<h3>Twitter and Google News based D3.js visualization on political events</h3>

A force layout visualization on current "Hot" events. Data source will be twitter search content based on Google news headlines.
The nodes will represent each entity's political origin ,the entity itself and the tweets posted for it respectively. The entire 
visualization is in realtime and it is also storing it's snapshots periodically. That said the user will be able to scroll through days and hours and construct the news diagram through time.


<h2>Install</h2>

1. Database.sql file must be imported into mysql to create the tables needed. If the .sql doesnt work you must first create the database manually and then import the file again.
2. If the tables have been created succesfully ,your Database credentials must be changed in /backend/credentials.php
3. For twitter search to work an api key is needed. You have to create one for yourself [here]( https://dev.twitter.com/rest/public/search). Api key needs to be entered in /backend/rssreader.php line 422.
4. At this point rssreader.php dependencies are ok and it should work. If it does not feel free to contact me.
5. Assuming that rssreader.php worked in /backend/data you should see a folder with the current date and inside this a basic-graph-data.json file and some hased-name json files.
6. Having checked that those files exist application is running and the only thing needed for persistency is setting a cronjob every hour.
7. hitting localhost/-your-dir-/frontend on your browser should visualize the nodes. If the nodes doenst appear , you have to check for the json files.


Feel free to ask anything.
G. Thanasis
p11gkli@ionio.gr
L. Anestis 
p11lato@ionio.gr

