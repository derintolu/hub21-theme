/**
 * FRS React Sidebar Entry Point
 *
 * Mounts the React sidebar component into the WordPress theme sidebar.
 */

import { StrictMode } from 'react';
import { createRoot } from 'react-dom/client';
import { Sidebar } from './components/Sidebar';
import './index.css';

// WordPress integration - look for the sidebar root element
const sidebarRoot = document.getElementById('lrh-portal-sidebar-root');

if (sidebarRoot) {
  // Get config from WordPress
  const config = (window as any).frsReactSidebarConfig || {};

  console.log('FRS React Sidebar mounting with config:', config);

  createRoot(sidebarRoot).render(
    <StrictMode>
      <Sidebar config={config} />
    </StrictMode>
  );

  console.log('FRS React Sidebar mounted successfully');
}
