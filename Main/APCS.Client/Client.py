import socket

# Set all the constant definitions
HOST, PORT = "127.0.1.1", 11000

def checkvehicle(reg):
    sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    sock.connect((HOST, PORT))
    reg += '<EOF>' # Means "End of File" - server needs this.
    sock.send(reg.encode())
    success = sock.recv(1024)
    print(success.decode())
    sock.close()

checkvehicle('<OUT>SM53YXN')