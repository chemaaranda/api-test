import { useState, useEffect } from "react";
import logo from './logo.svg';
import './App.css';
import DisplayApi from './DisplayApi';

function App() {

  const [content, setContent] = useState("*****************");
  const [endPonintsList, setEndPonintsList] = useState([]);

  const [callData, setCallData] = useState({
    endPoint: "https://api.coindesk.com/v1/bpi/currentprice.json",
    type: "GET",
    response: "",
    timestampCallStart: "",
    timestampCallEnd: ""
  });

  useEffect(() => {
    //Runs on the first render
    //And any time any dependency value changes
    console.log('useEfefect 2')
    setCallData(callData)
    console.log(callData)
}, [callData]);

  const startCall= () => {
    setContent("calling..." + callData.endPoint)
    setEndPonintsList([...endPonintsList, callData.endPoint])
    console.log(endPonintsList)
    setCallData(previousState => {
      return { ...previousState, timestampCallStart: Date.now() }
    });
    console.log(callData)
    console.log(endPonintsList)
    fetch(callData.endPoint, {
        "method": callData.type,
        "headers": {
        }
      })
    .then(res => res.json())
    .then(
      (result) => {
        /*this.setState({
          isLoaded: true,
          items: result.items
        });*/
        console.log(result)
        setContent(JSON.stringify(result))

      },
      // Note: it's important to handle errors here
      // instead of a catch() block so that we don't swallow
      // exceptions from actual bugs in components.
      (error) => {
        /*this.setState({
          isLoaded: true,
          error
        });*/
        console.log(error)
        setContent("ERROR")
      }
    )
  }

  const setEndpoint= (endpoint) => {
    setCallData(previousState => {
      return { ...previousState, endPoint: endpoint }
    });
  }
  
  const setType= (type) => {
    setCallData(previousState => {
      return { ...previousState, type: type }
    });
  }

  return (
    <div>  
      <label>Enter endpoint:</label>
        <input 
          type="text" 
          id="lname" 
          name="lname" 
          value={callData.endPoint} 
          onChange={(e) => setEndpoint(e.target.value)}
        ></input>
        <span>
        <select onChange={(e) => setType(e.target.value)}>
          <option value="PUT">PUT</option>
          <option value="GET">GET</option>
          <option value="POST">POST</option>
          <option value="DELETE">DELETE</option>
        </select>
      </span>
      
      <button onClick={startCall}>ENVIAR</button>
      <DisplayApi data = { content }/>
    </div>
  );
}

export default App;
