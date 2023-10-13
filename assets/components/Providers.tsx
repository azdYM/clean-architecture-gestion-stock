import { BodyContentContext, ClientContext, ClientSearchResult, HeaderContentContext } from "../functions/context"
import React, {useState} from "react"

// export const ClientSearchProvdier = ({children}: React.PropsWithChildren) =>
// {
//   const [searchValue, setSearchValue] = useState(null)

//   return (
//     <ClientSearchContext.Provider value={
//       {result: resultClientSearch, search: (data) => setResultClientSearch(data)}
//     }>
//       {children}
//     </ClientSearchContext.Provider>
//   )
// }

export const HeaderContentProvider = ({children}: React.PropsWithChildren) => 
{
  const [columns, setColumns] = useState<Array<any>>([])

  return (
    <HeaderContentContext.Provider value={
      {columns, setColumns: (columns) => setColumns(columns)}
    }>
      {children}
    </HeaderContentContext.Provider>
  )
}

export const BodyContentProvider = ({children}: React.PropsWithChildren) => 
{
  const [contents, setContents] = useState<Array<any>>([])

  return (
    <BodyContentContext.Provider value={{
      contents: contents, 
      updateContents: (newContent) => {
        setContents((currentContents) =>  [...currentContents, newContent])
      }
    }}>
      {children}
    </BodyContentContext.Provider>
  )
}

export const ClientProvider = function ({children, client}: React.PropsWithChildren<{client: ClientSearchResult|undefined}>)
{
  if (client === null || client === undefined) {
    return 
  }

  return (
    <ClientContext.Provider value={client}>
      {children}
    </ClientContext.Provider>
  )
}