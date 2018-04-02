from mongodb import MongoDbConnector
from mysql import MySQLConnector

if __name__ == '__main__':

    mysql_connector = MySQLConnector()
    mongodb_connector = MongoDbConnector()

    electronic_item_list = mysql_connector.select_electronic_item(0)
    electronic_specification_list = mysql_connector.select_electronic_specification(0)
    electronic_type_list = mysql_connector.select_electronic_type(0)
    login_log_list = mysql_connector.select_login_log(0)
    transaction_list = mysql_connector.select_transaction(0)
    user_list = mysql_connector.select_user(0)



    for model in electronic_item_list:
      mongodb_connector.insert_electronic_item(model)

    for model in electronic_specification_list:
      mongodb_connector.insert_electronic_specification(model)

    for model in electronic_type_list:
      mongodb_connector.insert_electronic_type(model)

    for model in login_log_list:
      mongodb_connector.insert_login_log(model)

    for model in transaction_list:
      mongodb_connector.insert_transaction(model)

    for model in user_list:
      mongodb_connector.insert_user(model)

    mysql_connector.update_last_forklift()

    print('Update Complete!')