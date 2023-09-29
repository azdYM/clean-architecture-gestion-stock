import React, { forwardRef, useEffect } from 'react'
import { $ } from '/functions/dom'
import { useMutationObserver } from '/functions/hooks'
import { hideSidebar, setPageTitle, showSidebar } from '/functions/utils'

export const Page = forwardRef(({children, className, title='Ma page', sidebar = false}, ref) => {
  setPageTitle(title)
  const {observe, disconnect} = useMutationObserver()
  const setPagePosition = (page, sidebarWidth) => page.style.marginLeft = `${sidebarWidth}px`

  useEffect(() => {
    if (sidebar) {
      hideSidebar()
      return () => showSidebar()
    }
  }, [])

  useEffect(() => {
    const pageManager = $('gck-page-manager', document)
    const sidebar = $('#guide-wrapper', document)
    const width = sidebar.getBoundingClientRect().width

    setPagePosition(pageManager, width)
    observe(sidebar, () => setPagePosition(pageManager, width))

    return () => disconnect()
  }, [])

  return (
    <gck-page-manager class={className} ref={ref}>
      {children}
    </gck-page-manager>
  )
})
