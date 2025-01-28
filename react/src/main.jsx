import { StrictMode } from 'react'
import { createRoot } from 'react-dom/client'
import './index.css'
import App from './App.jsx'
import {BrowserRouter, Route, Routes} from "react-router";
import Membre from "./components/Membre.jsx";

createRoot(document.getElementById('root')).render(
    <BrowserRouter>
        <StrictMode>
            <Routes>
                <Route path='/' element={<App />} />
                <Route path={'/membre/:id'} element={<Membre />} />
            </Routes>
        </StrictMode>
    </BrowserRouter>,
)
