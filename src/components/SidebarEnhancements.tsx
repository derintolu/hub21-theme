import { useEffect, useState } from 'react';
import { createRoot } from 'react-dom/client';

/**
 * Sidebar Header Component
 * Renders the gradient header with user profile
 */
function SidebarHeader() {
  const [userData, setUserData] = useState<{
    avatar: string;
    name: string;
    role: string;
  } | null>(null);

  useEffect(() => {
    // Fetch user data from WordPress REST API
    fetch('/wp-json/wp/v2/users/me', {
      credentials: 'include',
    })
      .then((res) => res.json())
      .then((data) => {
        setUserData({
          avatar: data.avatar_urls['96'] || '',
          name: data.name || '',
          role: 'Loan Officer', // You can make this dynamic based on role
        });
      })
      .catch((err) => console.error('Failed to fetch user data:', err));
  }, []);

  if (!userData) return null;

  return (
    <div style={{
      textAlign: 'center',
      marginBottom: '2rem',
      paddingBottom: '1.5rem',
      borderBottom: '1px solid rgba(255,255,255,0.1)',
    }}>
      <img
        src={userData.avatar}
        alt={userData.name}
        style={{
          width: '96px',
          height: '96px',
          borderRadius: '50%',
          marginBottom: '1rem',
          border: '3px solid rgba(255,255,255,0.2)',
        }}
      />
      <h3 style={{
        margin: '0 0 0.25rem 0',
        fontSize: '1.25rem',
        fontWeight: 600,
      }}>
        {userData.name}
      </h3>
      <p style={{
        margin: 0,
        fontSize: '0.875rem',
        color: 'rgba(255,255,255,0.7)',
      }}>
        {userData.role}
      </p>
    </div>
  );
}

/**
 * Sidebar Widgets Component
 * Renders profile completion and profile link widgets
 */
function SidebarWidgets() {
  const [profileCompletion, setProfileCompletion] = useState(0);
  const [profileSlug, setProfileSlug] = useState('');

  useEffect(() => {
    // Fetch user meta for profile completion and slug
    fetch('/wp-json/wp/v2/users/me', {
      credentials: 'include',
    })
      .then((res) => res.json())
      .then((data) => {
        // You can calculate profile completion based on filled fields
        setProfileCompletion(0); // Placeholder
        setProfileSlug(data.slug || '');
      })
      .catch((err) => console.error('Failed to fetch user data:', err));
  }, []);

  const handleCopy = () => {
    const profileUrl = `${window.location.origin}/lo/${profileSlug}`;
    navigator.clipboard.writeText(profileUrl);
    // You could add a toast notification here
  };

  const handleOpen = () => {
    const profileUrl = `${window.location.origin}/lo/${profileSlug}`;
    window.open(profileUrl, '_blank');
  };

  return (
    <div style={{
      paddingTop: '1.5rem',
      borderTop: '1px solid rgba(255,255,255,0.1)',
      marginTop: 'auto',
    }}>
      {/* Profile Completion Widget */}
      <div style={{
        background: 'rgba(255,255,255,0.05)',
        padding: '1rem',
        borderRadius: '0.5rem',
        marginBottom: '1rem',
      }}>
        <div style={{
          fontSize: '0.75rem',
          color: 'rgba(255,255,255,0.7)',
          marginBottom: '0.5rem',
        }}>
          PROFILE COMPLETION
        </div>
        <div style={{
          fontSize: '2rem',
          fontWeight: 700,
        }}>
          {profileCompletion}
          <span style={{ fontSize: '1.5rem' }}>%</span>
        </div>
      </div>

      {/* Profile Link Widget */}
      <div style={{
        background: 'rgba(255,255,255,0.05)',
        padding: '1rem',
        borderRadius: '0.5rem',
      }}>
        <div style={{
          fontSize: '0.75rem',
          color: 'rgba(255,255,255,0.7)',
          marginBottom: '0.5rem',
        }}>
          PROFILE LINK
        </div>
        <div style={{
          fontSize: '0.875rem',
          marginBottom: '0.75rem',
        }}>
          {profileSlug}
        </div>
        <div style={{
          display: 'flex',
          gap: '0.5rem',
        }}>
          <button
            onClick={handleCopy}
            style={{
              flex: 1,
              padding: '0.5rem',
              background: 'rgba(255,255,255,0.1)',
              border: 'none',
              borderRadius: '0.375rem',
              color: 'white',
              cursor: 'pointer',
              fontSize: '0.875rem',
            }}
          >
            Copy
          </button>
          <button
            onClick={handleOpen}
            style={{
              flex: 1,
              padding: '0.5rem',
              background: 'rgba(255,255,255,0.1)',
              border: 'none',
              borderRadius: '0.375rem',
              color: 'white',
              cursor: 'pointer',
              fontSize: '0.875rem',
            }}
          >
            Open
          </button>
        </div>
      </div>
    </div>
  );
}

/**
 * Initialize sidebar enhancements
 * Mounts React components to existing DOM elements
 */
export function initSidebarEnhancements() {
  // Mount header
  const headerRoot = document.getElementById('lrh-sidebar-header-root');
  if (headerRoot) {
    createRoot(headerRoot).render(<SidebarHeader />);
  }

  // Mount widgets
  const widgetsRoot = document.getElementById('lrh-sidebar-widgets-root');
  if (widgetsRoot) {
    createRoot(widgetsRoot).render(<SidebarWidgets />);
  }
}

// Auto-initialize when DOM is ready
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initSidebarEnhancements);
} else {
  initSidebarEnhancements();
}
