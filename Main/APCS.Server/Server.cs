using System;
using System.IO;
using System.Linq;
using System.Net;
using System.Net.Sockets;
using System.Text;

namespace APCS.Server 
{
	public class Server 
    {
		private static TcpListener _listener { get; set; }
		private static bool _accept { get; set; } = false;

		public static void StartServer(int port) 
        {
			IPAddress address = IPAddress.Parse("127.0.0.1");
			_listener = new TcpListener(address, port);

			_listener.Start();
			_accept = true;

			Console.WriteLine($"Server started. Listening to TCP clients at 127.0.0.1:{port}");
		}

		public static void Listen() 
        {
			if (_listener != null && _accept) 
            {
				// Continue listening.  
				while (true) 
                {
					Console.WriteLine("Waiting for client...");
					var clientTask = _listener.AcceptTcpClientAsync(); // Get the client  
					if (clientTask.Result != null) 
                    {
						Console.WriteLine("Client connected. Waiting for data.");
						var client = clientTask.Result;
						string message = "";

						while (message != null && !message.StartsWith("quit")) 
                        {
							byte[] data = Encoding.ASCII.GetBytes("Send next data: [enter 'quit' to terminate] ");
							client.GetStream().Write(data, 0, data.Length);

							byte[] buffer = new byte[client.ReceiveBufferSize];
							client.GetStream().Read(buffer, 0, buffer.Length);

							message = Encoding.ASCII.GetString(buffer);
                            if (message.EndsWith("<TXT>"))
                            {
                                Console.WriteLine(message);
                            }
                            else if (message.EndsWith("<IMG>"))
                            {
                                byte[] imageBuffer = buffer.Take(buffer.Count() - 1).ToArray();
                                File.WriteAllBytes("image.jpg", imageBuffer);
                                Console.WriteLine("Image received and written");

                                data = Encoding.ASCII.GetBytes("Got image successfully");
							    client.GetStream().Write(data, 0, data.Length);
                            }					
						}
						Console.WriteLine("Closing connection.");
						client.GetStream().Dispose();
					}
				}
			}
		}
    }
}