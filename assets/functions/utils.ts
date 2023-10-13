import { $ } from "./dom"

export const setPageTitle = (title: string) =>
{
  document.title = title
}

export const hideSidebar = () => {
  const sidebar = $('#guide-wrapper')
  if (sidebar === null) return

  sidebar.style.display = 'none'
}

export const showSidebar = () => {
  const sidebar = $('#guide-wrapper')
  if (sidebar === null) return

  sidebar.style.display = 'block'
}