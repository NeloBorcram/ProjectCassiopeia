# ProjectCassiopeia

*ProjectCassiopeia* is a hobby project of me trying to make a "Smart Terrarium" for my beautiful, little pet snake called Cassiopeia.

I set up a Raspberry Pi 3 as a LAN Webserver using Rasperian, Apache2, PHPMyAdmin, MySQL (LAMP).  
This repository includes the current WebPage running on the Webserver. Its purpose is to receive GET requests from WiFi Modules connected to the Terrarium.  
At the moment there is just one of such modules connected a WeMos ESP8266 mini which is connected to a DHT11 Temperature and Humidity Sensor.  

ToDo:  
- [x] Add a timestamp to the received GET request to show when the last transmission occured. :ballot_box_with_check:
- [ ] Start a database to be able to log all transmissions.  
- [ ] Make the look of the Website more stylish.  
- [ ] Add more sensors to the WiFi Module (Water level, brightness,...)  
- [ ] Add a new WiFiModule to control Actuators (Heating Lamp Relay, Heating Pad/Stone, Humidifier, Waterpump [for drinking water],       buttons/switches)  
- [ ] Add Website Buttons to control the actuators remotly.  
- [ ] Add graphs to visualize old sensordata.  
