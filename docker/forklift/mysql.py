import MySQLdb
import os
import sys
import models
import time


class MySQLConnector:
    database = 'conushop'
    user = 'root'
    password = 'isY2metT'
    host = 'localhost'

    def __init__(self):
        try:
            db = MySQLdb.connect(host=self.host, user=self.user, passwd=self.password, db=self.database)
        except KeyError:
            print("Key Error: Environment variables not correctly set")
            sys.exit(1)
        except:
            print("Could not connect to the mysql database")
            sys.exit(1)
        db.close()

    def select_electronic_item(self, x):
        electronic_item_list = []
        db = MySQLdb.connect(host=self.host, user=self.user, passwd=self.password, db=self.database)
        cursor = db.cursor()
        query = """SELECT 
        ElectronicItem.id,
        ElectronicSpecification.id,
        ElectronicSpecification.dimension,
        ElectronicSpecification.weight,
        ElectronicSpecification.modelNumber,
        ElectronicSpecification.brandName,
        ElectronicSpecification.hdSize,
        ElectronicSpecification.price,
        ElectronicSpecification.processorType,
        ElectronicSpecification.ramSize,
        ElectronicSpecification.cpuCores,
        ElectronicSpecification.batteryInfo,
        ElectronicSpecification.os,
        ElectronicSpecification.camera,
        ElectronicSpecification.touchScreen,
        ElectronicType.id,
        ElectronicType.name,
        ElectronicType.dimensionUnit,
        ElectronicType.screenSizeUnit,
        ElectronicSpecification.displaySize,
        ElectronicSpecification.image,
        ElectronicItem.serialNumber,        
        User.id,
        User.firstName,
        User.lastName,
        User.email,
        User.phone,
        User.admin,
        User.physicalAddress,
        User.password,
        User.remember_token,
        ElectronicItem.expiryForUser 
        FROM ElectronicItem
        INNER JOIN ElectronicSpecification on ElectronicItem.ElectronicSpecification_id = ElectronicSpecification.id
        INNER JOIN User on ElectronicItem.User_id = User.id
        INNER JOIN ElectronicType on ElectronicSpecification.ElectronicType_id = ElectronicType.id"""
        if x == 0:
            query = query + "\nWHERE ElectronicItem.last_forklift_or_change_check in (-1,0,2)"
            print query
        cursor.execute(query)
        results = cursor.fetchall()
        for r in results:
            electronic_item_model = models.ElectronicItem()
            electronic_specification_model = models.ElectronicSpecification()
            electronic_type_model = models.ElectronicType()
            user_model = models.User()
            electronic_item_model.id = r[0]
            electronic_specification_model.id = r[1]
            electronic_specification_model.dimension = r[2]
            electronic_specification_model.weight = r[3]
            electronic_specification_model.modelNumber = r[4]
            electronic_specification_model.brandName = r[5]
            electronic_specification_model.hdSize = r[6]
            electronic_specification_model.price = r[7]
            electronic_specification_model.processorType = r[8]
            electronic_specification_model.ramSize = r[9]
            electronic_specification_model.cpuCores = r[10]
            electronic_specification_model.batteryInfo = r[11]
            electronic_specification_model.os = r[12]
            electronic_specification_model.camera = r[13]
            electronic_specification_model.touchScreen = r[14]
            electronic_type_model.id = r[15]
            electronic_type_model.name = r[16]
            electronic_type_model.dimensionUnit = r[17]
            electronic_type_model.screenSizeUnit = r[18]
            electronic_specification_model.ElectronicType_id = electronic_type_model
            electronic_specification_model.displaySize = r[19]
            electronic_specification_model.image = r[20]
            electronic_item_model.ElectronicSpecification_id = electronic_specification_model
            electronic_item_model.serialNumber = r[21]
            user_model.id = r[22]
            user_model.firstName = r[23]
            user_model.lastName = r[24]
            user_model.email = r[25]
            user_model.phone = r[26]
            user_model.admin = r[27]
            user_model.physicalAddress = r[28]
            user_model.password = r[29]
            user_model.remember_token = r[30]
            electronic_item_model.user_id = user_model
            electronic_item_model.expiryForUser = r[31]
            electronic_item_list.append(electronic_item_model)
        db.close()
        return electronic_item_list

    def select_electronic_specification(self,x):
        electronic_specification_list = []
        db = MySQLdb.connect(host=self.host, user=self.user, passwd=self.password, db=self.database)
        cursor = db.cursor()
        query = """SELECT 
        ElectronicSpecification.id,
        ElectronicSpecification.dimension,
        ElectronicSpecification.weight,
        ElectronicSpecification.modelNumber,
        ElectronicSpecification.brandName,
        ElectronicSpecification.hdSize,
        ElectronicSpecification.price,
        ElectronicSpecification.processorType,
        ElectronicSpecification.ramSize,
        ElectronicSpecification.cpuCores,
        ElectronicSpecification.batteryInfo,
        ElectronicSpecification.os,
        ElectronicSpecification.camera,
        ElectronicSpecification.touchScreen,
        ElectronicType.id,
        ElectronicType.name,
        ElectronicType.dimensionUnit,
        ElectronicType.screenSizeUnit,
        ElectronicSpecification.displaySize,
        ElectronicSpecification.image
        FROM ElectronicSpecification
        INNER JOIN ElectronicType on ElectronicSpecification.ElectronicType_id = ElectronicType.id"""
        if x == 0:
         query = query + "\nWHERE ElectronicSpecification.last_forklift_or_change_check in (-1,0,2)"
        cursor.execute(query)
        results = cursor.fetchall()
        for r in results:
            electronic_specification_model = models.ElectronicSpecification()
            electronic_type_model = models.ElectronicType()
            electronic_specification_model.id = r[0]
            electronic_specification_model.dimension = r[1]
            electronic_specification_model.weight = r[2]
            electronic_specification_model.modelNumber = r[3]
            electronic_specification_model.brandName = r[4]
            electronic_specification_model.hdSize = r[5]
            electronic_specification_model.price = r[6]
            electronic_specification_model.processorType = r[7]
            electronic_specification_model.ramSize = r[8]
            electronic_specification_model.cpuCores = r[9]
            electronic_specification_model.batteryInfo = r[10]
            electronic_specification_model.os = r[11]
            electronic_specification_model.camera = r[12]
            electronic_specification_model.touchScreen = r[13]
            electronic_type_model.id = r[14]
            electronic_type_model.name = r[15]
            electronic_type_model.dimensionUnit = r[16]
            electronic_type_model.screenSizeUnit = r[17]
            electronic_specification_model.ElectronicType_id = electronic_type_model
            electronic_specification_model.displaySize = r[18]
            electronic_specification_model.image = r[19]
            electronic_specification_list.append(electronic_specification_model)
        db.close()
        return electronic_specification_list

    def select_electronic_type(self,x):
        electronic_type_list = []
        db = MySQLdb.connect(host=self.host, user=self.user, passwd=self.password, db=self.database)
        cursor = db.cursor()
        query = "SELECT * FROM ElectronicType"
        if x == 1:
            query = query + "\nWHERE ElectronicType.last_forklift_or_change_check in (-1,0,2)"
        cursor.execute(query)
        results = cursor.fetchall()
        for r in results:
            model = models.ElectronicType()
            model.id = r[0]
            model.name = r[1]
            model.dimensionUnit = r[2]
            model.screenSizeUnit = r[3]
            electronic_type_list.append(model)
        db.close()
        return electronic_type_list

    def select_login_log(self,x):
        login_log_list = []
        db = MySQLdb.connect(host=self.host, user=self.user, passwd=self.password, db=self.database)
        cursor = db.cursor()
        query = """SELECT
        LoginLog.id,
        LoginLog.timestamp,
        User.id,
        User.firstName,
        User.lastName,
        User.email,
        User.phone,
        User.admin,
        User.physicalAddress,
        User.password,
        User.remember_token        
        FROM LoginLog
        INNER JOIN User ON LoginLog.User_id = User.id"""
        cursor.execute(query)
        results = cursor.fetchall()
        for r in results:
            login_log_model = models.LoginLog()
            user_model = models.User()
            login_log_model.id = r[0]
            login_log_model.timestamp = r[1]
            user_model.id = r[2]
            user_model.firstName = r[3]
            user_model.lastName = r[4]
            user_model.email = r[5]
            user_model.phone = r[6]
            user_model.admin = r[7]
            user_model.physicalAddress = r[8]
            user_model.password = r[9]
            user_model.remember_token = r[10]
            login_log_model.User_id = user_model
            login_log_list.append(login_log_model)
        db.close()
        return login_log_list

    def select_transaction(self,x):
        transaction_list = []
        db = MySQLdb.connect(host=self.host, user=self.user, passwd=self.password, db=self.database)
        cursor = db.cursor()
        query = """SELECT 
        Transaction.id,
        ElectronicSpecification.id,
        ElectronicSpecification.dimension,
        ElectronicSpecification.weight,
        ElectronicSpecification.modelNumber,
        ElectronicSpecification.brandName,
        ElectronicSpecification.hdSize,
        ElectronicSpecification.price,
        ElectronicSpecification.processorType,
        ElectronicSpecification.ramSize,
        ElectronicSpecification.cpuCores,
        ElectronicSpecification.batteryInfo,
        ElectronicSpecification.os,
        ElectronicSpecification.camera,
        ElectronicSpecification.touchScreen,
        ElectronicType.id,
        ElectronicType.name,
        ElectronicType.dimensionUnit,
        ElectronicType.screenSizeUnit,
        ElectronicSpecification.displaySize,
        ElectronicSpecification.image,
        Transaction.item_id,
        Transaction.serialNumber,
        Transaction.timestamp,
        User.id,
        User.firstName,
        User.lastName,
        User.email,
        User.phone,
        User.admin,
        User.physicalAddress,
        User.password,
        User.remember_token
        FROM Transaction
        INNER JOIN ElectronicSpecification ON Transaction.ElectronicSpec_id = ElectronicSpecification.id
        INNER JOIN ElectronicType ON ElectronicSpecification.ElectronicType_id = ElectronicType.id
        INNER JOIN User ON Transaction.customer_id = User.id"""

        cursor.execute(query)
        results = cursor.fetchall()
        for r in results:
            transaction_model = models.Transaction()
            electronic_specification_model = models.ElectronicSpecification()
            electronic_type_model = models.ElectronicType()
            user_model = models.User()
            transaction_model.id = r[0]
            electronic_specification_model.id = r[1]
            electronic_specification_model.dimension = r[2]
            electronic_specification_model.weight = r[3]
            electronic_specification_model.modelNumber = r[4]
            electronic_specification_model.brandName = r[5]
            electronic_specification_model.hdSize = r[6]
            electronic_specification_model.price = r[7]
            electronic_specification_model.processorType = r[8]
            electronic_specification_model.ramSize = r[9]
            electronic_specification_model.cpuCores = r[10]
            electronic_specification_model.batteryInfo = r[11]
            electronic_specification_model.os = r[12]
            electronic_specification_model.camera = r[13]
            electronic_specification_model.touchScreen = r[14]
            electronic_type_model.id = r[15]
            electronic_type_model.name = r[16]
            electronic_type_model.dimensionUnit = r[17]
            electronic_type_model.screenSizeUnit = r[18]
            electronic_specification_model.ElectronicType_id = electronic_type_model
            electronic_specification_model.displaySize = r[19]
            electronic_specification_model.image = r[20]
            transaction_model.ElectronicSpec_id = electronic_specification_model
            transaction_model.item_id = r[21]
            transaction_model.serialNumber = r[22]
            transaction_model.timestamp = r[23]
            user_model.id = r[24]
            user_model.firstName = r[25]
            user_model.lastName = r[26]
            user_model.email = r[27]
            user_model.phone = r[28]
            user_model.admin = r[29]
            user_model.physicalAddress = r[30]
            user_model.password = r[31]
            user_model.remember_token = r[32]
            transaction_model.customer_id = user_model
            transaction_list.append(transaction_model)
        db.close()
        return transaction_list

    def select_user(self,x):
        user_list = []
        db = MySQLdb.connect(host=self.host, user=self.user, passwd=self.password, db=self.database)
        cursor = db.cursor()
        query = "SELECT * FROM User"
        if x in (-1,0,2):
           query = query + "\nWHERE User.last_forklift_or_change_check in (-1,0,2)"
        cursor.execute(query)
        results = cursor.fetchall()
        for r in results:
            user_model = models.User()
            user_model.id = r[0]
            user_model.firstName = r[1]
            user_model.lastName = r[2]
            user_model.email = r[3]
            user_model.phone = r[4]
            user_model.admin = r[5]
            user_model.physicalAddress = r[6]
            user_model.password = r[7]
            user_model.remember_token = r[8]
            user_list.append(user_model)
        db.close()
        return user_list

    def update_last_forklift(self):
        db = MySQLdb.connect(host=self.host, user=self.user, passwd=self.password, db=self.database)
        cursor = db.cursor()
        cursor.execute("update ElectronicItem set last_forklift_or_change_check = 1")
        cursor.execute("update ElectronicSpecification set last_forklift_or_change_check = 1")
        cursor.execute("update ElectronicType set last_forklift_or_change_check = 1")
        cursor.execute("update LoginLog set last_forklift_or_change_check = 1")
        cursor.execute("update Transaction set last_forklift_or_change_check = 1")
        cursor.execute("update User set last_forklift_or_change_check = 1")
        db.commit()
        db.close()

    def select_items_changed(self):
         db = MySQLdb.connect(host=self.host, user=self.user, passwd=self.password, db=self.database)
         cursor = db.cursor()
