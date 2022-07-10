<h2>Fleet Management System</h2>
    <p>bus booking system a hiring task for Robusta Studio's</p>
    
<h3>Environment</h3>
    <ul>
        <li> PHP 8 - Laravel 9</li>
        <li> Mysql db</li>
        <li> Homestead Vagrant for local development environment</li>
    </ul>
    
<h3>Installation</h3>
    
1- clone repository
```
git clone https://github.com/MohamedEmadAbdelsatar/Robusta-Task.git
cd fleet-management
```
2- install dependencies
```
composer update
 ```
3- copy .env.example and rename it to .env
       
        
4- add project directory to Homestead.yaml folders, chenge mapping to url, rename db to fleet-management and enable mysql in features
```
folders:
       - map: C:\Bitnami\wampstack-8.0.20-0\apache2\htdocs\fleet-management
         to: /home/vagrant/code
         type: "nfs"
        
sites:
      - map: homestead.test
        to: /home/vagrant/code/public

databases:
      - fleet-management

features:
      - mysql: true
```
5- Download Homestead vagrant box
```
vagrant box add laravel/homestead
```

6- Edit hosts file to match your local domain
open C:\Windows\System32\drivers\etc\hosts
and add 
```
#Homestead
ip from Homestead.yaml   fleet-management.test
```

7- run vagrant
```
vagrant up
```

8- use Putty to connect to homestead via ssh

9- after connecting to homestead in Homestead terminal
```
cd code
php artisan migrate
php artisan db:seed
```

<p> Here we go the app is ready </P>
<p> I used this tutorial to run app in homestead environment <a href="https://mirror-medium.com/?m=https%3A%2F%2Fmedium.com%2Fm%2Fglobal-identity%3FredirectUrl%3Dhttps%253A%252F%252Fblog.devgenius.io%252Finstall-laravel-8-x-on-win-10-with-homestead-virtualbox-ec996f9a2cb6">Here</a>
    
<h3>DB Design</h3>
<img src="https://i.imgur.com/iR4d42I_d.webp?maxwidth=760&fidelity=grand">
<p>trips table is related to it's starting station , end station, cross over stations and has 12 seats, each seat is related to it's reservations and each reservation is related to one seat, from, to stations and it's trip</p>

<h3> Api end points</h3>
<p>here is the documentation <a href="https://documenter.getpostman.com/view/7845030/UzJPMv9M">Link</a>
    
1- http://fleet-management.test/api/trips [GET] returns all trips including it's stations from start to end and it's seats
```
{
  "data": [
    {
      "id": 28,
      "name": "Cairo - Alexandria",
      "stations": [
        "Cairo",
        "Qaliubiya",
        "Menofia",
        "Gharbiya",
        "Beheira",
        "Alexandria"
      ],
      "seats": [
        {
          "id": 301,
          "number_in_bus": 1
        },
        {
          "id": 302,
          "number_in_bus": 2
        },
      ]
    },
]
```
    
2- http://fleet-management.test/api/trips/28  [GET] return one trip by it's id

```
{
  "data": {
    "id": 28,
    "name": "Cairo - Alexandria",
    "stations": [
      "Cairo",
      "Qaliubiya",
      "Menofia",
      "Gharbiya",
      "Beheira",
      "Alexandria"
    ],
    "seats": [
      {
        "id": 301,
        "number_in_bus": 1
      },
      {
        "id": 302,
        "number_in_bus": 2
      },
      {
        "id": 303,
        "number_in_bus": 3
      },
      {
        "id": 304,
        "number_in_bus": 4
      },
      {
        "id": 305,
        "number_in_bus": 5
      },
      {
        "id": 306,
        "number_in_bus": 6
      },
      {
        "id": 307,
        "number_in_bus": 7
      },
      {
        "id": 308,
        "number_in_bus": 8
      },
      {
        "id": 309,
        "number_in_bus": 9
      },
      {
        "id": 310,
        "number_in_bus": 10
      },
      {
        "id": 311,
        "number_in_bus": 11
      },
      {
        "id": 312,
        "number_in_bus": 12
      }
    ]
  }
}
```
    
3- create trip http://fleet-management.test/api/trips [POST]
Request: 
```
{
    "stations" : ["Ismailia", "Suez", "Port Said", "South Sinai", "North Sinai"]
}
```
Response:
```
{
  "data": {
    "id": 33,
    "name": "Ismailia - North Sinai",
    "stations": [
      "Ismailia",
      "Suez",
      "Port Said",
      "South Sinai",
      "North Sinai"
    ],
    "seats": [
      {
        "id": 361,
        "number_in_bus": 1
      },
      {
        "id": 362,
        "number_in_bus": 2
      },
      {
        "id": 363,
        "number_in_bus": 3
      },
      {
        "id": 364,
        "number_in_bus": 4
      },
      {
        "id": 365,
        "number_in_bus": 5
      },
      {
        "id": 366,
        "number_in_bus": 6
      },
      {
        "id": 367,
        "number_in_bus": 7
      },
      {
        "id": 368,
        "number_in_bus": 8
      },
      {
        "id": 369,
        "number_in_bus": 9
      },
      {
        "id": 370,
        "number_in_bus": 10
      },
      {
        "id": 371,
        "number_in_bus": 11
      },
      {
        "id": 372,
        "number_in_bus": 12
      }
    ]
  }
}
```
    
4- get available seats  http://fleet-management.test/api/availability [GET] return an array of available seats with it's trips start and end 
Request:
```
{
    "from" : "Port Said",
    "to" : "Cairo"
}
```
Response:
```
{
  "data": [
    {
      "id": 313,
      "trip": "Port Said - Cairo",
      "number_in_bus": 1
    },
    {
      "id": 314,
      "trip": "Port Said - Cairo",
      "number_in_bus": 2
    },
 ]
}
```
    
5- Book a seat http://fleet-management.test/api/book [POST]
Request:
```
{
    "seat_id" : 314,
    "from" : "Port Said",
    "to" : "Cairo"
}
```
Response: trip details
```
{
  "data": {
    "id": 1,
    "trip": "Port Said - Cairo",
    "seat_number": 2,
    "from": "Port Said",
    "to": "Cairo"
  }
}
```
    
<p>Thank you for your time, I hope that reach your expectations</p>
