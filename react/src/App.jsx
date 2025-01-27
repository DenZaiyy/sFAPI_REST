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
      <div className="grid grid-cols-2 gap-4">
          {membres ? membres.map((membre) => (
              <div key={membre.id} className="relative p-4 flex flex-col gap-2 border border-black rounded">
                  <div className="flex gap-4 items-center">
                      <img src={membre.picture} alt="" className="rounded-full" />
                      <div>
                        <p>{membre.last.toUpperCase()} {membre.first}</p>
                          <p>{membre.email}</p>
                      </div>
                  </div>
                  <div className="flex gap-2 items-center justify-between">
                      <p>{membre.phone}</p>
                      <p>{membre.city}</p>
                      <p>{membre.country}</p>
                  </div>
              </div>
          )) :
              <h1>Aucune données...</h1>
          }
      </div>
    </>
  )
}

export default App
