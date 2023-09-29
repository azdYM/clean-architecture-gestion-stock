import { BodyContentContext, ClientContext, HeaderContentContext } from "/functions/context"
import React, {useState} from "react"

export const ClientDataProvider = ({children}) =>
{
  const [client, setClient] = useState(null)

  return (
    <ClientContext.Provider value={
      {client: client, updateClient: (data) => setClient(data)}
    }>
      {children}
    </ClientContext.Provider>
  )
}

export const HeaderContentProvider = ({children}) => 
{
  const [columns, setColumns] = useState([])

  return (
    <HeaderContentContext.Provider value={
      {columns, setColumns: (columns) => setColumns(() => columns)}
    }>
      <>
        {children}
      </>
    </HeaderContentContext.Provider>
  )
}

export const BodyContentProvider = ({children}) => 
{
  const [contents, setContents] = useState([])

  return (
    <BodyContentContext.Provider value={{
      contents, 
      updateContents: (newContent) => 
        setContents((currentContents) => [...currentContents, newContent])
    }}>
      <>
        {children}
      </>
    </BodyContentContext.Provider>
  )
}

