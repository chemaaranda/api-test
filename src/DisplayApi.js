import { useState, useEffect } from "react";
import './App.css';
function DisplayApi(props) {

    const [content, setContent] = useState("");

    useEffect(() => {
            setContent(props.data)
    }, [props]);

return (
    <div>
      {content}
    </div>
  );
}

export default DisplayApi;
