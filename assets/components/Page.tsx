import React, { forwardRef, useEffect } from 'react'
import { $ } from '../functions/dom'
import { useMutationObserver } from '../functions/hooks'
import { hideSidebar, setPageTitle, showSidebar } from '../functions/utils'

type PagePropsType = {className?: string, pageTitle?: string, sidebarShowed?: boolean}

export const Page = forwardRef<HTMLDivElement, React.PropsWithChildren<PagePropsType>>((
  {children, className, pageTitle, sidebarShowed = true}, ref
) => 
{
  const defaultPageTitle = 'Bienvenu mon ami !'
  const {observe, disconnect} = useMutationObserver()

  const setPageContentPosition = (pageContent: HTMLElement, sidebarWidth: number) => {
    pageContent.style.marginLeft = `${sidebarWidth}px`
  }

  useEffect(() => {
    setPageTitle(pageTitle ?? defaultPageTitle)
    return () => setPageTitle(defaultPageTitle)
  }, [])

  useEffect(() => {
    if (!sidebarShowed) {
      hideSidebar()
      return () => showSidebar()
    }
  }, [])

  useEffect(() => {
    const pageManager = $('#gck-page-manager') as HTMLElement
    const sidebar = $('#guide-wrapper') as HTMLElement
    const width = sidebar.getBoundingClientRect().width

    setPageContentPosition(pageManager, width)
    observe(sidebar, () => setPageContentPosition(pageManager, width), ['style'])

    return () => disconnect()
  }, [])

  return (
    <div id='gck-page-manager' className={className} ref={ref}>
      {children}
    </div>
  )
})
