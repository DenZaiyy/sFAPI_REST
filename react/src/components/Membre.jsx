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
        <div className="flex flex-col items-center justify-center gap-4">
            <img src={membre.picture} alt="" className="rounded-full w-64 h-64" />
            <p><strong>Fullname:</strong> {membre.last} {membre.first}</p>
            <p><strong>Email:</strong> {membre.email}</p>
            <p><strong>Phone:</strong> {membre.phone}</p>
            <p><strong>City:</strong> {membre.city}</p>
            <p><strong>Country:</strong> {membre.country}</p>
        </div>
    )
}

export default Membre
