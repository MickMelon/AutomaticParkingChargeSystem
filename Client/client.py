import requests

URL = "https://mayar.abertay.ac.uk/~cmp311gc1801/index.php?controller=api&action=check"
CARPARKID = 1 # ID of the carpark this client belongs to

def check(type, carparkid, reg):
    params = {'type':type, 'carparkid':carparkid, 'reg':reg}
    result = requests.get(url = URL, params = params)
    data = result.json()

    return data['Message']

def handle_entry():
    print('Entry is allowed')
    # Raise the barrier or something here

def handle_exit():
    print('Exit is allowed')
    # Raise the barrier or something here

def handle_error(error_message):
    print('Some error happened (' + error_message + ')')
    # Maybe some better error handling here

# TODO:
    # Detect vehicle
    # Take picture
    # Put picture through OpenALPR
    # Set reg variable from result
    # Check if reg is in car park so we know what type to specify
    # Call the function below with result

# Call to the check function
message = check('exit', CARPARKID, 'sa07enw')

# Check the result
if message == 'ENTRY_SUCCESS':
    handle_entry()
elif message == 'EXIT_SUCCESS':
    handle_exit()
else:
    handle_error(message)