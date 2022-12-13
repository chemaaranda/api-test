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
    data: "{'id': 1234}",
    headers : "{'Content-Type': 'application/json'}",
    type: "GET",
    response: "",
    timestampCallStart: "",
    timestampCallEnd: ""
  });

  useEffect(() => {
    //Runs on the first render
    //And any time any dependency value changes
    setCallData(callData)
}, [callData]);

  const startCall= () => {
    // alert('check data has a valid JSON')
    setMsg("calling..." + callData.endPoint)
    setEndPonintsList([...endPonintsList, callData.endPoint])
    setCallData(previousState => {
      return { ...previousState, timestampCallStart: Date.now() }
    });
    
    console.log(callData)

    let callConfig = {};
    callConfig = {
      "method": callData.type,
      }
      if(callData.type !== 'GET') callConfig.body = JSON.stringify(callData.data) 

    fetch(callData.endPoint, callConfig)
    .then(res => res.json())
    .then(
      (result) => {
        setMsg("")
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
        setMsg("ERROR " + error)
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
    <div className="container"> 
      <section className="section">
        <h1 className="title">
          Easy Online API Test
        </h1>
        <div className="field">
          <label>Endpoint:</label>
          <input 
            className="input"
            type="text" 
            id="lname" 
            name="lname" 
            value={callData.endPoint} 
            onChange={(e) => setEndpoint(e.target.value)}
          ></input>
        </div>
        
        <div className="columns">
          <div className="column">
            <div className="field">  
              <label>Headers:</label>
              <textarea 
                className= "textarea"
                onChange={(e) => setHeaders(e.target.value)}
                value={callData.headers}>
              </textarea>
            </div>
          </div>
          <div className="column">
            <div className="field">
              <label>Data:</label>
              <textarea 
                className= "textarea"
                onChange={(e) => setData(e.target.value)}
                value={callData.data}>
              </textarea>
            </div>
          </div>
          <div className="column">
            <div className="field">
              <label>Method:</label>
              <br></br>
              <div className="select">
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

        <div className="field">
          <center>
            <button 
              className="button is-medium is-primary" 
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
