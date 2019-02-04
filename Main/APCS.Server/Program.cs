using System;
using System.IO;
using System.Linq;
using System.Net.Http;
using System.Text;
using System.Threading.Tasks;
using Newtonsoft.Json;

namespace APCS.Server
{
    class Program
    {
        private static readonly HttpClient client = new HttpClient();

        public static async Task<Vehicle> ReadReg(string imagePath)
        {
            string response = await ProcessImage(imagePath);
            var vehicle = new Vehicle(response);
            return vehicle;
        }

        public static async Task<string> ProcessImage(string image_path)
        {
            string SECRET_KEY = "sk_b814e91e23aaf4bfc8403ff3";

            Byte[] bytes = File.ReadAllBytes(image_path);
            string imagebase64 = Convert.ToBase64String(bytes);

            var content = new StringContent(imagebase64);

            var response = await client.PostAsync("https://api.openalpr.com/v2/recognize_bytes?recognize_vehicle=1&country=gb&secret_key=" + SECRET_KEY, content).ConfigureAwait(false);

            var buffer = await response.Content.ReadAsByteArrayAsync().ConfigureAwait(false);
            var byteArray = buffer.ToArray();
            var responseString = Encoding.UTF8.GetString(byteArray, 0, byteArray.Length);

            return responseString;
        }

        static void Main(string[] args)
        {
            Task<Vehicle> recognizeTask = Task.Run(() => ReadReg(@"car.jpg"));
            recognizeTask.Wait();
            var vehicle = recognizeTask.Result;

            if (vehicle.Error)
            {
                Console.WriteLine("It fucked up...");
            }
            else
            {
                Console.WriteLine($"Reg: {vehicle.Reg}");
                Console.WriteLine($"Confidence: {vehicle.Confidence}");
                Console.WriteLine($"Processing Time: {vehicle.ProcessingTime}");
            }
        }
    }
}
