import { useState, useEffect } from "react";
import parse from 'html-react-parser';

import './App.css';
function DisplayApi(props) {

  const [content, setContent] = useState("");
  const [msg, setMsg] = useState("");

  function syntaxHighlight(json) {
    if (typeof json != 'string') {
         json = JSON.stringify(json, undefined, 4);
    }
    json = json.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
    return json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function (match) {
        var cls = 'number';
        if (/^"/.test(match)) {
            if (/:$/.test(match)) {
                cls = 'key';
            } else {
                cls = 'string';
            }
        } else if (/true|false/.test(match)) {
            cls = 'boolean';
        } else if (/null/.test(match)) {
            cls = 'null';
        }
        console.log('<span class="' + cls + '">' + match + '</span>')
        return '<span class="' + cls + '">' + match + '</span>';
    });
}
    useEffect(() => {
      // let _data = props.data ? JSON.stringify(JSON.parse(props.data), null, 4) : ""    
      let _data = props.data ? syntaxHighlight(JSON.parse(props.data)) : ""
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
