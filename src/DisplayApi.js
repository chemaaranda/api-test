import { useState, useEffect } from "react";
import parse from 'html-react-parser';

import './App.css';
function DisplayApi(props) {

  const [content, setContent] = useState("");
  const [msg, setMsg] = useState("");

    useEffect(() => {  
      let _data = props.data ? '<pre>' +JSON.stringify(JSON.parse(props.data), undefined, 2) + '</pre>' : ""
      setContent(_data)
      setMsg(props.msg)
    }, [props]);

return (
    <div>
      <div>
        {msg}
      </div>
      <div>
        {parse(content)}
      </div>
    </div>
  );
}

export default DisplayApi;
