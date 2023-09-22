import { createContext } from "react";

export const SearchContext = createContext({search: null, updateSearch: null});

export const PopupContext = createContext({popupActived: false})

export const AppContext = createContext({})