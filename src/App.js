import { useState, useEffect } from "react";
import './App.css';
import './bulma-rtl.min.css';
import DisplayApi from './DisplayApi';
import { validJSON } from './utils';

function App() {

  let acceptedCookies = document.cookie.includes("acceptedCookies=true")
  console.log('document.cookie.includes("acceptedCookies=true"): ' + document.cookie.includes("acceptedCookies=true"))
  console.log(document.cookie)
  console.log("acceptedCookies: " + acceptedCookies)
  /*
  if(!document.cookie.includes("acceptedCookies=true")){
    console.log('setting cookie')
    document.cookie = 'acceptedCookies=true;'
    console.log('===>> ' + document.cookie)
  }
  */

  const [displayData, setDisplayData] = useState({
    content: "",
    msg: "",
    type : ""
  });

  const [callData, setCallData] = useState({
    endPoint: "http://www.easy-online-api-test.com/API/api.php",
    data: "{\"id\": 1234}",
    headers : "{\"Content-Type\": \"application/json\"}",
    type: "GET"
  });

  useEffect(() => {
    setCallData(callData)
}, [callData]);

  const startCall= () => {
    setDisplayData({ content: "{}", msg: "", type: "info" });
    // check JSON 
    let validJSONs = true

    if((callData.data.trim().length !== 0) && (! validJSON(callData.data))){
        setDisplayData({ content: "{}", msg: "ERROR IN DATA JSON", type: "error" })
        validJSONs = false
      }

    if((callData.headers.trim().length !== 0) && (! validJSON(callData.headers))){
        setDisplayData({ content: "{}", msg: "ERROR IN HEADERS JSON", type: "error" })
        validJSONs = false
      }

    if(validJSONs){
      setDisplayData({ content: "{}", msg: callData.endPoint, type: "info" });
      
      let callConfig = {};
      callConfig = {
        "method": callData.type,
        }
        if(callData.type !== 'GET') 
          callConfig.body = JSON.stringify(callData.data) 
          else{
            if(callData.data.trim().length !== 0)
              try {
                  let _obj = JSON.parse(callData.data)
                  let queryString = ''
                  for (const item of Object.entries(_obj)) {
                    queryString += item[0] + '=' + item[1] + "&"
                  }
                  if (queryString.length !== 0){
                    queryString = queryString.slice(0, -1)
                    setEndpoint(callData.endPoint + '?' + queryString)
                    setData("")
                  } 
              } catch (error) {
                setDisplayData({content: "{}", msg: "ERROR" + callData.endPoint, type: "error" });
              }
          }
  
      fetch(callData.endPoint, callConfig)
      .then(res => res.json())
      .then(
        (result) => {
          setDisplayData({ content: JSON.stringify(result), msg: "" + callData.endPoint, type: "success" });
        },
        (error) => {
          setDisplayData({ content: "{}", msg: "ERROR", type: "error" });
        }
      )
    }
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
     <div class="modal" is-active>
          <div class="modal-background"></div>
          <div class="modal-card">
            <header class="modal-card-head">
              <p class="modal-card-title">Modal title</p>
              <button class="delete" aria-label="close"></button>
            </header>
            <section class="modal-card-body">
              YO HAVE TO ACCEPT COOKIES!!!
            </section>
            <footer class="modal-card-foot">
              <button class="button is-success">Save changes</button>
              <button class="button">Cancel</button>
            </footer>
          </div>
        </div>
    {!acceptedCookies &&
        <div class="modal">
          <div class="modal-background"></div>
          <div class="modal-card">
            <header class="modal-card-head">
              <p class="modal-card-title">Modal title</p>
              <button class="delete" aria-label="close"></button>
            </header>
            <section class="modal-card-body">
              YO HAVE TO ACCEPT COOKIES!!!
            </section>
            <footer class="modal-card-foot">
              <button class="button is-success">Save changes</button>
              <button class="button">Cancel</button>
            </footer>
          </div>
        </div>
      }
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
                  <option value="GET">GET</option>
                  <option value="PUT">PUT</option>
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
        <DisplayApi 
            msg ={displayData.msg} 
            data = { displayData.content } 
            type = { displayData.type } 
        />
      </section>
    </div>
  );
}

export default App;
