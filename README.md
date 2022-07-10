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
        copy .env.example and rename it to .env
        ```
        
3- add project directory to Homestead.yaml folders, chenge mapping to url, rename db to fleet-management and enable mysql in features
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
