/*
  # This sample code is used to test the pH meter Pro V1.0.
  # Editor : YouYou
  # Ver    : 1.0
  # Product: analog pH meter Pro
  # SKU    : SEN0169
*/
#include <SoftwareSerial.h>
#define SensorPin A0            //pH meter Analog output to Arduino Analog Input 0
#define Offset 0.00            //deviation compensate
#define LED 13
#define samplingInterval 40
#define printInterval 5000
#define ArrayLenth  40    //times of collection
int pHArray[ArrayLenth];   //Store the average value of the sensor feedback
int pHArrayIndex = 0;
int lightPin = 2; 
/* to communicate with the Bluetooth module's TXD pin */
#define BT_SERIAL_TX 10
/* to communicate with the Bluetooth module's RXD pin */
#define BT_SERIAL_RX 11
/* Initialise the software serial port */
SoftwareSerial BluetoothSerial(BT_SERIAL_TX, BT_SERIAL_RX);


void setup(void)
{
   pinMode( LED, OUTPUT );
  pinMode(LED, OUTPUT);
  Serial.begin(9600);
  Serial.println("BV kit initializing diagnostic process......!");    //Test the serial monitor
  BluetoothSerial.begin(57600); // Initialise BlueTooth
delay(1000);
BluetoothSerial.print("Starting ...");
}
void loop(void)
{
  static unsigned long samplingTime = millis();
  static unsigned long printTime = millis();
  static float pHValue, voltage;
  if (millis() - samplingTime > samplingInterval)
  {
    pHArray[pHArrayIndex++] = analogRead(SensorPin);
    if (pHArrayIndex == ArrayLenth)pHArrayIndex = 0;
    voltage = avergearray(pHArray, ArrayLenth) * 5.0 / 1024;
    pHValue = 3.5 * voltage + Offset;
    samplingTime = millis();
  }
  if (millis() - printTime > printInterval)  //Every 800 milliseconds, print a numerical, convert the state of the LED indicator
  {
    Serial.print("LIGHT:");
    Serial.print(analogRead(lightPin)); //Write the value of the photoresistor to the serial monitor.
    analogWrite(LED, analogRead(lightPin)/4); 
    //send the value to the ledPin. Depending on value of resistor 
     //you have  to divide the value. for example, 
     //with a 10k resistor divide the value by 2, for 100k resistor divide by 4.
      Serial.print("-MOISTURE:");
      Serial.print(analogRead(4));
      Serial.print("-DEPTH:");
      Serial.print(analogRead(3));
      Serial.print("-SMELL:");
      Serial.print(analogRead(2));
      Serial.print("-Voltage:");
      Serial.print(voltage, 2);
      Serial.print("-pH value: ");
      Serial.println(pHValue, 2);    
      BluetoothSerial.print(pHValue);
    
    digitalWrite(LED, digitalRead(LED) ^ 1);
   // printTime = millis();
    delay(5000); //short delay for faster response to light.
  }
}
double avergearray(int* arr, int number) {
  int i;
  int max, min;
  double avg;
  long amount = 0;
  if (number <= 0) {
    Serial.println("Error number for the array to avraging!/n");
    return 0;
  }
  if (number < 5) { //less than 5, calculated directly statistics
    for (i = 0; i < number; i++) {
      amount += arr[i];
    }
    avg = amount / number;
    return avg;
  } else {
    if (arr[0] < arr[1]) {
      min = arr[0]; max = arr[1];
    }
    else {
      min = arr[1]; max = arr[0];
    }
    for (i = 2; i < number; i++) {
      if (arr[i] < min) {
        amount += min;      //arr<min
        min = arr[i];
      } else {
        if (arr[i] > max) {
          amount += max;  //arr>max
          max = arr[i];
        } else {
          amount += arr[i]; //min<=arr<=max
        }
      }//if
    }//for
    avg = (double)amount / (number - 2);
  }//if
  return avg;
}
