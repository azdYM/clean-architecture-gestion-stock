import { 
  AppContext, 
  AttestationContext, 
  AttestationsContext, 
  BodyContentContext, 
  ClientContext, 
  HeaderContentContext, 
  UserContext, 
} from "../functions/context"
import React, {useState} from "react"
import { ClientData } from "./CardClient"
import { UserData } from "../api/user"
import { AttestationData } from "../api/attestation"

export const AppProvider = ({children, user}: React.PropsWithChildren<{user?: UserData}>) => {
	return (
		<AppContext.Provider value={{}}>
			<UserContext.Provider value={user}>
				{ children }
			</UserContext.Provider>
		</AppContext.Provider>
	)
}

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

export const ClientProvider = function ({children, client}: React.PropsWithChildren<{client: ClientData|undefined|null}>)
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

export const UserProvider = function ({children, user}: React.PropsWithChildren<{user: UserData|undefined}>)
{
  if (user === null || user === undefined) {
    return 
  }

  return (
    <UserContext.Provider value={user}>
      {children}
    </UserContext.Provider>
  )
}

type AttestationProviderProps = {
  data?: AttestationData|null,
  refetchData?: CallableFunction
}

export const AttestationProvider = function ({children, data, refetchData}: React.PropsWithChildren<AttestationProviderProps>)
{
  if (data === null || data === undefined) {
    return 
  }

  return (
    <AttestationContext.Provider value={{data, refetch: refetchData}}>
      {children}
    </AttestationContext.Provider>
  )
}

export const AttestationsProvider = function ({children, data}: React.PropsWithChildren<{data: AttestationData[]|undefined}>)
{
  if (data === null || data === undefined) {
    return 
  }

  return (
    <AttestationsContext.Provider value={data}>
      {children}
    </AttestationsContext.Provider>
  )
}