import { useState, useEffect } from "react";
import logo from './logo.svg';
import './App.css';
import './bulma-rtl.min.css';
import DisplayApi from './DisplayApi';

function App() {

  const [content, setContent] = useState();
  const [endPonintsList, setEndPonintsList] = useState([]);
  const [callMsg, setMsg] = useState()

  const [callData, setCallData] = useState({
    endPoint: "https://api.coindesk.com/v1/bpi/currentprice.json",
    data: "{id: 1234}",
    headers : "{'Content-Type': 'application/json'}",
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
    // alert('check data has a valid JSON')
    setMsg("calling..." + callData.endPoint)
    setEndPonintsList([...endPonintsList, callData.endPoint])
    setCallData(previousState => {
      return { ...previousState, timestampCallStart: Date.now() }
    });
    console.log(callData)
    console.log(endPonintsList)

    let callConfig = {};
    callConfig = {
      "method": callData.type,
      }
      if(callData.type !== 'GET') callConfig.body = JSON.stringify(callData.data) 

      console.log(callConfig)

    fetch(callData.endPoint, callConfig)
    .then(res => res.json())
    .then(
      (result) => {
        setMsg("")
        /*this.setState({
          isLoaded: true,
          items: result.items
        });*/
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
        setMsg("ERROR")
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
  
  const setData= (data) => {
    setCallData(previousState => {
      return { ...previousState, data: data }
    });
  }

  const setHeaders= (headers) => {
    setCallData(previousState => {
      return { ...previousState, headers: headers }
    });
  }

  return (
    <div class="container"> 
      <section class="section">
        <h1 class="title">
          Easy online API test
        </h1>
        <div class="field">
          <label>Endpoint:</label>
          <input 
            class="input"
            type="text" 
            id="lname" 
            name="lname" 
            value={callData.endPoint} 
            onChange={(e) => setEndpoint(e.target.value)}
          ></input>
        </div>
        
        <div class="columns">
          <div class="column">
            <div class="field">  
              <label>Headers:</label>
              <textarea 
                class= "textarea"
                onChange={(e) => setHeaders(e.target.value)}>
                {callData.headers}
              </textarea>
            </div>
          </div>
          <div class="column">
            <div class="field">
              <label>Data:</label>
              <textarea 
                class= "textarea"
                onChange={(e) => setData(e.target.value)}>
                {callData.data}
              </textarea>
            </div>
          </div>
          <div class="column">
            <div class="field">
              <label>Method:</label>
              <br></br>
              <div class="select">
                <select onChange={(e) => setType(e.target.value)}>
                  <option value="PUT">GET</option>
                  <option value="GET">PUT</option>
                  <option value="POST">POST</option>
                  <option value="DELETE">DELETE</option>
                </select>
              </div>
            </div>
          </div>
        </div>

        <div class="field">
          <center>
            <button 
              class="button is-medium is-primary" 
              onClick={startCall}>SEND
            </button>
          </center>
        </div>
        <DisplayApi msg ={callMsg} data = { content }/>
      </section>
    </div>
  );
}

export default App;
