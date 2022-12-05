import { useState, useEffect } from "react";
import './App.css';
function DisplayApi(props) {

  const [content, setContent] = useState("");
  const [msg, setMsg] = useState("");

    useEffect(() => {
      setContent(props.data)
      setMsg(props.msg)
    }, [props]);

return (
    <div>
      <div>
        {msg}
      </div>
      <div>
        {content}
      </div>
    </div>
  );
}

export default DisplayApi;
