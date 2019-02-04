using Newtonsoft.Json.Linq;

namespace APCS.Server
{
    public class Vehicle
    {
        public Vehicle(string json)
        {
            var jObject = JObject.Parse(json);
            var result = jObject["results"][0];
            
            Error = (bool) jObject["error"];
            Reg = (string) result["plate"];
            Confidence = (float) result["confidence"];
            ProcessingTime = (float) result["processing_time_ms"];            
        }

        public bool Error { get; set; }
        public string Reg { get; set; }
        public double Confidence { get; set; }
        public double ProcessingTime { get; set; }
    }
}