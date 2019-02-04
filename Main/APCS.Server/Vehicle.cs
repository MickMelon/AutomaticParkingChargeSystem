using Newtonsoft.Json.Linq;

namespace APCS.Server
{
    /// <summary>
    /// Used for storing all the data received from OpenALPR.
    /// </summary>
    public class Vehicle
    {
        /// <summary>
        /// Initializes a new instance of the <see cref="Vehicle"> class.
        /// </summary>
        /// <param name="json">The JSON string containing all the vehicle data.</param>
        public Vehicle(string json)
        {
            var jObject = JObject.Parse(json);
            var result = jObject["results"][0];
            
            Error = (bool) jObject["error"];
            Reg = (string) result["plate"];
            Confidence = (float) result["confidence"];
            ProcessingTime = (float) result["processing_time_ms"];            
        }

        /// <summary>
        /// Indicates whether there was an error in reading the registration.
        /// </summary>
        public bool Error { get; set; }

        /// <summary>
        /// The registration number.
        /// </summary>
        public string Reg { get; set; }

        /// <summary>
        /// The percentage of confidence that OpenALPR has in determining whether
        /// it has read it correctly.
        /// </summary>
        public double Confidence { get; set; }

        /// <summary>
        /// The time in milliseconds for how long it took to process.
        /// </summary>
        public double ProcessingTime { get; set; }
    }
}