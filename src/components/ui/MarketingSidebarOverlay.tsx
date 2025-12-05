import { ArrowLeft, Calendar, FileText, ShoppingBag, Home } from 'lucide-react';
import { cn } from './utils';

interface MarketingSidebarOverlayProps {
  activeItemId: string;
  onItemClick: (path: string) => void;
  onBackClick: () => void;
  isCollapsed?: boolean;
  backgroundColor?: string;
  textColor?: string;
  activeItemColor?: string;
  activeItemBackground?: string;
}

export function MarketingSidebarOverlay({
  activeItemId,
  onItemClick,
  onBackClick,
  isCollapsed = false,
  backgroundColor = '#ffffff',
  textColor = '#374151',
  activeItemColor = '#ffffff',
  activeItemBackground = 'linear-gradient(135deg, #2563eb 0%, #2dd4da 100%)',
}: MarketingSidebarOverlayProps) {
  const marketingItems = [
    { id: '/marketing', label: 'Overview', icon: Home },
    { id: '/marketing/calendar', label: 'Calendar', icon: Calendar },
    { id: '/marketing/landing-pages', label: 'Landing Pages', icon: FileText },
    { id: '/marketing/orders', label: 'Social & Print', icon: ShoppingBag },
  ];

  if (isCollapsed) {
    return null;
  }

  return (
    <div
      className="absolute inset-0 z-50 flex flex-col"
      style={{
        backgroundColor,
        color: textColor,
      }}
    >
      {/* Back Button */}
      <button
        onClick={onBackClick}
        className="w-full inline-flex items-center gap-2 text-sm font-medium transition-all rounded-md h-9 px-4 py-2 mb-4 hover:bg-accent hover:text-accent-foreground"
        style={{
          border: 'none',
          outline: 'none',
          cursor: 'pointer',
        }}
      >
        <ArrowLeft className="size-4 flex-shrink-0" />
        <span className="flex-1 text-left">Back</span>
      </button>

      {/* Marketing Navigation Items */}
      <nav className="flex-1 space-y-2">
        {marketingItems.map((item) => {
          const Icon = item.icon;
          const isActive = activeItemId === item.id || activeItemId.startsWith(item.id + '/');

          return (
            <button
              key={item.id}
              onClick={() => onItemClick(item.id)}
              className={cn(
                'w-full inline-flex items-center gap-2 text-sm font-medium transition-all rounded-md h-9 px-4 py-2',
                !isActive && 'hover:bg-accent hover:text-accent-foreground',
                isActive && 'shadow-sm'
              )}
              style={{
                backgroundColor: isActive ? 'transparent' : 'transparent',
                backgroundImage: isActive ? activeItemBackground : 'none',
                color: isActive ? activeItemColor : textColor,
                border: 'none',
                outline: 'none',
                cursor: 'pointer',
              }}
            >
              <Icon className="size-4 flex-shrink-0" />
              <span className="flex-1 text-left">{item.label}</span>
            </button>
          );
        })}
      </nav>
    </div>
  );
}
