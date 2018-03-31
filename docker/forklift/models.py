class ElectronicItem:
    def __init__(self):
        self.id = None
        self.ElectronicSpecification_id = None
        self.serialNumber = None
        self.user_id = None
        self.expiryForUser = None


class ElectronicSpecification:
    def __init__(self):
        self.id = None
        self.dimension = None
        self.weight = None
        self.modelNumber = None
        self.brandName = None
        self.hdSize = None
        self.price = None
        self.processorType = None
        self.ramSize = None
        self.cpuCores = None
        self.batteryInfo = None
        self.os = None
        self.camera = None
        self.touchScreen = None
        self.ElectronicType_id = None
        self.displaySize = None
        self.image = None


class ElectronicType:
    def __init__(self):
        self.id = None
        self.name = None
        self.dimensionUnit = None
        self.screenSizeUnit = None


class LoginLog:
    def __init__(self):
        self.id = None
        self.timestamp = None
        self.User_id = None


class Transaction:
    def __init__(self):
        self.id = None
        self.ElectronicSpec_id = None
        self.item_id = None
        self.serialNumber = None
        self.timestamp = None
        self.customer_id = None


class User:
    def __init__(self):
        self.id = None
        self.firstName = None
        self.lastName = None
        self.emial = None
        self.phone = None
        self.admin = None
        self.physicalAddress = None
        self.password = None
        self.remember_token = None
