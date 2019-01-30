using OpenAlprApi.Api;
using OpenAlprApi.Model;
using System;
using System.IO;
using System.Net;
using System.Net.Sockets;
using System.Text;

namespace APCSPrototype
{
    class Program
    {
        const string SERVER_IP = "127.0.0.1";
        const int PORT_NO = 7777;

        static void Main(string[] args)
        {
            var address = IPAddress.Parse(SERVER_IP);
            var listener = new TcpListener(IPAddress.Any, PORT_NO);
            Console.WriteLine("Starting...");
            listener.Start();
            Console.WriteLine("Started!");
            bool running = true;

            while (running)
            {
                var client = listener.AcceptTcpClient();

                var netStream = client.GetStream();
                byte[] buffer = new byte[client.ReceiveBufferSize];

                File.WriteAllBytes("image.jpg", buffer);

                int bytesRead = netStream.Read(buffer, 0, client.ReceiveBufferSize);
                string dataReceived = Encoding.ASCII.GetString(buffer, 0, bytesRead);

                Console.WriteLine($"Data received");
                netStream.Write(buffer, 0, bytesRead);

                Console.WriteLine("\n");
                client.Close();

                File.WriteAllBytes("image.jpg", buffer);

                if (bytesRead > 0) running = false;
                if (running) Console.WriteLine("Still running");
            }

            listener.Stop();
            OpenAlpr("image.jpg");


        }

        static void OpenAlpr(string imageUrl)
        {
            string base64ImageRepresentation = Convert.ToBase64String(File.ReadAllBytes(@imageUrl));

            var apiInstance = new DefaultApi();
            var imageBytes = base64ImageRepresentation;  // string | The image file that you wish to analyze encoded in base64 
            var secretKey = "sk_7c140a1c4f8b1b7e0d8025e8";  // string | The secret key used to authenticate your account.  You can view your  secret key by visiting  https://cloud.openalpr.com/ 
            var country = "gb";  // string | Defines the training data used by OpenALPR.  \"us\" analyzes  North-American style plates.  \"eu\" analyzes European-style plates.  This field is required if using the \"plate\" task  You may use multiple datasets by using commas between the country  codes.  For example, 'au,auwide' would analyze using both the  Australian plate styles.  A full list of supported country codes  can be found here https://github.com/openalpr/openalpr/tree/master/runtime_data/config 
            var recognizeVehicle = 1;  // int? | If set to 1, the vehicle will also be recognized in the image This requires an additional credit per request  (optional)  (default to 0)
                                       // var state = state_example;  // string | Corresponds to a US state or EU country code used by OpenALPR pattern  recognition.  For example, using \"md\" matches US plates against the  Maryland plate patterns.  Using \"fr\" matches European plates against  the French plate patterns.  (optional)  (default to )
            var returnImage = 0;  // int? | If set to 1, the image you uploaded will be encoded in base64 and  sent back along with the response  (optional)  (default to 0)
            var topn = 10;  // int? | The number of results you would like to be returned for plate  candidates and vehicle classifications  (optional)  (default to 10)
                            // var prewarp = prewarp_example;  // string | Prewarp configuration is used to calibrate the analyses for the  angle of a particular camera.  More information is available here http://doc.openalpr.com/accuracy_improvements.html#calibration  (optional)  (default to )

            try
            {
                InlineResponse200 result = apiInstance.RecognizeBytes(imageBytes, secretKey, country, recognizeVehicle, null, returnImage, topn, null);
                Console.WriteLine(result);
                foreach (var res in result.Results)
                {
                    Console.WriteLine($"Plate: {res.Plate}");

                    Console.WriteLine($"Color: {res.Vehicle.Color[0]}");
                    Console.WriteLine($"Body: {res.Vehicle.BodyType[0]}");
                    Console.WriteLine($"Make: {res.Vehicle.Make[0]}");
                    Console.WriteLine($"MakeModel: {res.Vehicle.MakeModel[0]}");
                }
            }
            catch (Exception e)
            {
                Console.WriteLine("Exception when calling DefaultApi.RecognizeBytes: " + e.Message);
            }

            Console.ReadKey();
        }
    }
}
