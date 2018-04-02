from pymongo import MongoClient
import os


class MongoDbConnector:
    database = 'conushop'
    user = 'root'
    host = 'localhost'

    def __init__(self):
        self.client = MongoClient()

    def reset(self):
        collections = self.client[self.database].collection_names()
        for name in collections:
            print('Deleting Collection: {}'.format(name))
            self.client[self.database].drop_collection(name)
        print('MongoDb reset successfully')

    def insert_electronic_item(self, electronic_item_model):
        self.client[self.database]['ElectronicItem'].insert_one(electronic_item_model.jsonify())

    def insert_electronic_specification(self, electronic_specification_model):
        self.client[self.database]['ElectronicSpecification'].insert_one(electronic_specification_model.jsonify())

    def insert_electronic_type(self, electronic_type_model):
        self.client[self.database]['ElectronicType'].insert_one(electronic_type_model.jsonify())

    def insert_login_log(self, login_log_model):
        self.client[self.database]['LoginLog'].insert_one(login_log_model.jsonify())

    def insert_transaction(self, transaction_model):
        self.client[self.database]['Transaction'].insert_one(transaction_model.jsonify())

    def insert_user(self, user_model):
        self.client[self.database]['User'].insert_one(user_model.jsonify())