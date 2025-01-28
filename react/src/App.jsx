import {useEffect, useState} from 'react'
function App() {
    const [membres, setMembres] = useState([])

    const apiMembres = "https://localhost:8000/api/membres"

    useEffect(() => {
        fetch(apiMembres)
            .then(response => response.json())
            .then(data => setMembres(data['member']))
            .catch(error => console.log(error))
    }, [])

  return (
    <>
      <div className="grid grid-flow-col gap-4">
          {membres ? membres.map((membre) => (
              <a href={"/membre/"+membre.id} key={membre.id} className="p-4 flex flex-col gap-2 border border-black rounded">
                  <div className="flex gap-4 items-center">
                      <img src={membre.picture} alt="" className="rounded-full" />
                        <p>{membre.last.toUpperCase()} {membre.first}</p>
                  </div>
              </a>
          )) :
              <h1>Aucune données...</h1>
          }
      </div>
    </>
  )
}

export default App
