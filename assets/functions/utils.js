import { $ } from "./dom"

export const setPageTitle = (title) =>
{
  document.title = title
}

export const hideSidebar = () => {
  const sidebar = $('#guide-wrapper', document)
  console.log(sidebar, 'hidesidebar')
  sidebar.style.display = 'none'
}

export const showSidebar = () => {
  const sidebar = $('#guide-wrapper', document)
  sidebar.style.display = 'block'
}