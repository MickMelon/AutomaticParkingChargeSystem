using System;
using System.Threading.Tasks;

namespace APCS.Server
{
    /// <summary>
    /// The class that starts the program up.
    /// </summary>
    public class Program
    {
        /// <summary>
        /// The method that starts the program up.
        /// </summary>
        public static void Main(string[] args)
        {
            Server.StartServer(7777);
            Server.Listen();
        }

        private static void DoOpenALPR()
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
