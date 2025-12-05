/**
 * Global component exports for use by plugins
 * Exposes components to window.FRSComponents
 */

import { MarketingSidebarOverlay } from './components/ui/MarketingSidebarOverlay';
import { PortalSidebarLayout } from './components/ui/PortalSidebarLayout';
import { ProfileEditProvider } from './contexts/ProfileEditContext';
import { cn } from './components/ui/utils';

// Expose to global window object
declare global {
  interface Window {
    FRSComponents: {
      MarketingSidebarOverlay: typeof MarketingSidebarOverlay;
      PortalSidebarLayout: typeof PortalSidebarLayout;
      ProfileEditProvider: typeof ProfileEditProvider;
      cn: typeof cn;
    };
  }
}

// Initialize global object
window.FRSComponents = {
  MarketingSidebarOverlay,
  PortalSidebarLayout,
  ProfileEditProvider,
  cn,
};

console.log('FRS Components loaded:', Object.keys(window.FRSComponents));
