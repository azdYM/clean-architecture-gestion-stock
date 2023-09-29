import { createContext } from "react";

export const SearchContext = createContext({search: null, updateSearch: null});

export const PopupContext = createContext({popupActived: false})

export const AppContext = createContext({})

export const ClientContext = createContext({type: null})

export const HeaderContentContext = createContext({columns: [], setColumns: null})

export const BodyContentContext = createContext({contents: [], updateContents: null})
