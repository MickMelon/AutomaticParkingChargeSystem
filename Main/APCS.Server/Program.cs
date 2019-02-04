using System;
using System.IO;
using System.Linq;
using System.Net.Http;
using System.Text;
using System.Threading.Tasks;
using Newtonsoft.Json;

namespace APCS.Server
{
    /// <summary>
    /// The class that starts the program up.
    /// </summary>
    class Program
    {
        /// <summary>
        /// The method that starts the program up.
        /// </summary>
        static void Main(string[] args)
        {
            Task<Vehicle> recognizeTask = Task.Run(() => OpenALPR.ReadReg(@"car.jpg"));
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
