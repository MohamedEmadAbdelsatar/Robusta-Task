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
<img src="https://imgur.com/gallery/oecBkBl">
<blockquote class="imgur-embed-pub" lang="en" data-id="a/oecBkBl"  ><a href="//imgur.com/a/oecBkBl">db design</a></blockquote><script async src="//s.imgur.com/min/embed.js" charset="utf-8"></script>
