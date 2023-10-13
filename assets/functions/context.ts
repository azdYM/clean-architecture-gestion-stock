import { createContext } from "react";

export type IndividualType = {
    id: number,
    folio: number,
    name: string,
    gender: ('M'|'F')
    nickname: string
    locations: [],
    contacts: []
}

export type CorporateType = {
    id: number,
    folio: number,
    name: string,
    legalForm: string,
    activityDomain: string,
    comericialRegistry: string,
    locations: [],
    contacts: []
}

export type ClientSearchResult = {
    clientType: string,
    client: (IndividualType|CorporateType),
    persisted: boolean
}

type SearchContextValuesType = {
    search: string|null, 
    updateSearch: null|((searchValue: React.SetStateAction<string>) => void)
}

type HeaderContentContextType = {
    columns: any[], 
    setColumns: null|((columns: any[]) => void )
}

type BodyContentContextType = {
    contents: []|Array<any>, 
    updateContents: null|((content: any) => void)
}

type PopupContextType = {popupActived: boolean}

export const SearchContext = createContext<SearchContextValuesType>({search: null, updateSearch: null});

export const PopupContext = createContext<PopupContextType>({popupActived: false})

export const AppContext = createContext({})

export const HeaderContentContext = createContext<HeaderContentContextType>({columns: [], setColumns: null})

export const BodyContentContext = createContext<BodyContentContextType>({contents: [], updateContents: null})

export const ClientContext = createContext<ClientSearchResult|null>(null)
