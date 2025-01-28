import {useEffect, useState} from "react";
import { useParams } from "react-router";

function Membre()
{
    const {id} = useParams()
    const [membre, setMembre] = useState({})

    useEffect(() => {
        fetch("https://localhost:8000/api/membres/"+id)
            .then(response => response.json())
            .then(data => setMembre(data))
            .catch(error => console.log(error))
    }, []);
    return (
        <>
            <p>{membre.last} {membre.first}</p>
        </>
    )
}

export default Membre
