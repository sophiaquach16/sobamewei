### Dependencies
1) Python 2
2) MySQLdb
    1. pip install MySQLdb 
3) pymongo
    1. pip install pymongo
4) MongoDb
5) Environement variables: host, password, database

### Running the script
1) cd /sobamewei/docker/forklift
2) python migration.py

### MongoDb Structure
1) Database --> 'conushop'
    ```
    'conushop':{
        'User':{
        },
        'LoginLog':{
        },
        'Transaction':{
        },
        'ElectronicSpecification':{
        },
        'ElectronicType':{
        },
        'ElectronicItem':{
        }
    }
    ```
1) Collections:
    1. **User**
    ```
    {
        'id': int,
        'firstName': string,
        'lastName': string,
        'email': string,
        'phone': string,
        'admin': int,
        'physicalAddress': string,
        'password': string,
        'remember_token': string
    }
    ```
 
    2. **Transaction**
    ```
    {
        'id': int,
        'ElectronicSpec_id': ElectronicSpecification dictionary,
        'item_id': int,
        'serialNumber': int,
        'timestamp': int,
        'customer_id': User dictionary
    }
    ```
    
    3. **LoginLog**
    ```
    {
        'id': int,
        'timestamp': int,
        'User_id': User dictionary
    }
    ```
    4. **ElectronicSpecification**
    ```
    {
        'id': int,
        'dimension': string,
        'weight': float,
        'modelNumber': string,
        'brandName': string,
        'hdSize': string,
        'price': string,
        'processorType': string,
        'ramSize': string,
        'cpuCores': int,
        'batteryInfo': string,
        'os': string,
        'camera': int,
        'touchScreen': int,
        'ElectronicType_id': ElectronicType dictionary,
        'displaySize': double,
        'image': string
    }
    ```
    5. **ElectronicItem**
    ```
    {
        'id': int,
        'ElectronicSpecification_id': ElectronicSpecification dictionary,
        'serialNumber': int,
        'user_id': User dictionary,
        'expiryForUser': int
    }
    ```
    
    6. **ElectronicType**
    ```
    {
        'id': int,
        'name': string,
        'dimensionUnit': string,
        'screenSizeUnit': int
    }
    ```
    
