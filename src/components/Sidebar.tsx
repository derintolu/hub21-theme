/**
 * FRS React Sidebar Component
 *
 * Main sidebar component that renders in the WordPress theme sidebar area.
 */

import { useState, useEffect } from 'react';

interface SidebarConfig {
  ajaxUrl: string;
  restUrl: string;
  nonce: string;
  isLoggedIn: boolean;
  currentUserId: number;
}

interface ProfileData {
  id: number;
  first_name: string;
  last_name: string;
  email: string;
  select_person_type: string;
  photo_url?: string;
}

interface SidebarProps {
  config: SidebarConfig;
}

export function Sidebar({ config }: SidebarProps) {
  const [profile, setProfile] = useState<ProfileData | null>(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    if (config.isLoggedIn && config.currentUserId) {
      fetchUserProfile();
    } else {
      setLoading(false);
    }
  }, [config.isLoggedIn, config.currentUserId]);

  async function fetchUserProfile() {
    try {
      const response = await fetch(`${config.restUrl}profiles/user/me`, {
        headers: {
          'X-WP-Nonce': config.nonce,
        },
      });

      if (response.ok) {
        const data = await response.json();
        if (data.success && data.data) {
          setProfile(data.data);
        }
      }
    } catch (error) {
      console.error('Error fetching profile:', error);
    } finally {
      setLoading(false);
    }
  }

  function getInitials(firstName?: string, lastName?: string): string {
    const first = firstName?.charAt(0) || '';
    const last = lastName?.charAt(0) || '';
    return (first + last).toUpperCase() || 'U';
  }

  function getPersonTypeLabel(type: string): string {
    const labels: Record<string, string> = {
      loan_officer: 'Loan Officer',
      agent: 'Real Estate Agent',
      staff: 'Staff',
      leadership: 'Leadership',
      assistant: 'Assistant',
    };
    return labels[type] || type;
  }

  if (loading) {
    return (
      <div className="frs-sidebar">
        <div className="frs-sidebar-section animate-pulse">
          <div className="h-4 bg-gray-200 rounded w-3/4 mb-2"></div>
          <div className="h-4 bg-gray-200 rounded w-1/2"></div>
        </div>
      </div>
    );
  }

  return (
    <div className="frs-sidebar">
      {/* User Profile Card - Only show if logged in */}
      {config.isLoggedIn && profile && (
        <div className="frs-sidebar-section">
          <div className="frs-profile-card">
            {profile.photo_url ? (
              <img
                src={profile.photo_url}
                alt={`${profile.first_name} ${profile.last_name}`}
                className="w-10 h-10 rounded-full object-cover"
              />
            ) : (
              <div className="frs-profile-avatar">
                {getInitials(profile.first_name, profile.last_name)}
              </div>
            )}
            <div className="frs-profile-info">
              <div className="frs-profile-name">
                {profile.first_name} {profile.last_name}
              </div>
              <div className="frs-profile-role">
                {getPersonTypeLabel(profile.select_person_type)}
              </div>
            </div>
          </div>
        </div>
      )}

      {/* Quick Navigation */}
      <div className="frs-sidebar-section">
        <h3 className="frs-sidebar-title">Quick Links</h3>
        <nav className="frs-sidebar-nav">
          <a href="/portal" className="frs-sidebar-nav-item">
            <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            Dashboard
          </a>
          <a href="/portal#my-profile" className="frs-sidebar-nav-item">
            <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            My Profile
          </a>
          <a href="/directory" className="frs-sidebar-nav-item">
            <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            Team Directory
          </a>
          <a href="/portal#settings" className="frs-sidebar-nav-item">
            <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            Settings
          </a>
        </nav>
      </div>

      {/* Info Widget */}
      <div className="frs-sidebar-section">
        <div className="frs-widget-card">
          <h4 className="frs-widget-card-title">Need Help?</h4>
          <p className="frs-widget-card-content">
            Contact support for assistance with your profile or account settings.
          </p>
          <a
            href="mailto:support@21stcenturylending.com"
            className="inline-flex items-center gap-1 mt-2 text-sm font-medium text-blue-600 hover:text-blue-800"
          >
            Get Support
            <svg className="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
            </svg>
          </a>
        </div>
      </div>
    </div>
  );
}
