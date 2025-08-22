@extends('layouts.app')

@section('styles')
<style>
  /* Core variables */
  :root {
    --card-radius: 12px;
    --shadow-soft: 0 3px 15px rgba(0, 0, 0, 0.04);
    --transition-smooth: all 0.2s ease;
    --space-unit: 8px;
    --primary-color: #4a6fa5;
    --secondary-color: #47B475;
    --bg-color: #f5f7fa;
    --text-primary: #2d3748;
    --text-secondary: #596677;
    --border-light: #e5e9f0;
  }
  
  /* Base page styling */
  .community-page {
    padding: var(--space-unit) 0 calc(var(--space-unit) * 3);
    background-color: var(--bg-color);
    min-height: calc(100vh - 70px);
    font-size: 16px;
  }
  
  /* 3-column Grid Layout - Core Structure */
  .community-layout {
    display: grid;
    grid-template-columns: 240px 1fr 300px;
    gap: calc(var(--space-unit) * 2);
    max-width: 100%;
  }
  
  /* Column assignments to prevent layout shifts */
  .left-sidebar {
    grid-column: 1;
    grid-row: 1;
  }
  
  .feed-main {
    grid-column: 2;
    grid-row: 1;
  }
  
  .right-sidebar {
    grid-column: 3;
    grid-row: 1;
  }
  
  /* Fixed sidebars */
  .left-sidebar, 
  .right-sidebar {
    position: sticky;
    top: calc(var(--space-unit) * 8);
    height: calc(100vh - 120px);
    overflow-y: auto;
    scrollbar-width: thin;
    padding-bottom: var(--space-unit);
  }
  
  .left-sidebar::-webkit-scrollbar,
  .right-sidebar::-webkit-scrollbar {
    width: 4px;
  }
  
  .left-sidebar::-webkit-scrollbar-thumb,
  .right-sidebar::-webkit-scrollbar-thumb {
    background-color: rgba(0,0,0,0.1);
    border-radius: 20px;
  }
  
  /* Sticky navigation & filters */
  .community-nav {
    position: sticky;
    top: 0;
    background-color: white;
    margin-bottom: var(--space-unit);
    border-bottom: 1px solid var(--border-light);
    z-index: 100;
    box-shadow: var(--shadow-soft);
    padding: calc(var(--space-unit) * 1.5) 0;
  }
  
  .nav-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  
  .community-heading {
    display: flex;
    align-items: center;
    gap: calc(var(--space-unit) * 1.5);
  }
  
  .community-heading h1 {
    font-size: 1.4rem;
    font-weight: 700;
    margin: 0;
    color: var(--text-primary);
  }
  
  /* Search and filter bar */
  .search-filter-bar {
    display: flex;
    align-items: center;
    gap: calc(var(--space-unit) * 1.5);
    padding: calc(var(--space-unit) * 1.5);
    background-color: white;
    border-radius: var(--card-radius);
    box-shadow: var(--shadow-soft);
    margin-bottom: calc(var(--space-unit) * 2);
  }
  
  .search-box {
    flex: 1;
    position: relative;
  }
  
  .search-box input {
    width: 100%;
    padding: calc(var(--space-unit) * 1) calc(var(--space-unit) * 4) calc(var(--space-unit) * 1) calc(var(--space-unit) * 1);
    border-radius: calc(var(--space-unit) * 2);
    border: 1px solid var(--border-light);
    font-size: 0.9rem;
  }
  
  .search-icon {
    position: absolute;
    right: calc(var(--space-unit) * 1.5);
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-secondary);
  }
  
  /* Filter pills */
  .filter-pills {
    display: flex;
    gap: calc(var(--space-unit) * 1);
    flex-wrap: wrap;
  }
  
  .filter-pill {
    border: none;
    background-color: #f0f2f7;
    color: var(--text-secondary);
    padding: calc(var(--space-unit) * 0.75) calc(var(--space-unit) * 1.5);
    border-radius: 20px;
    font-size: 0.9rem;
    cursor: pointer;
    transition: var(--transition-smooth);
    font-weight: 500;
  }
  
  .filter-pill:hover {
    background-color: #e5e9f2;
  }
  
  .filter-pill.active {
    background-color: var(--primary-color);
    color: white;
  }
  
  /* Alert styling */
  .alert-message {
    border-radius: var(--card-radius);
    padding: calc(var(--space-unit) * 1.5);
    margin-bottom: calc(var(--space-unit) * 2);
    font-weight: 500;
    display: flex;
    align-items: center;
    font-size: 0.95rem;
  }
  
  .alert-message::before {
    content: "✓";
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background-color: rgba(40, 167, 69, 0.15);
    color: #28a745;
    margin-right: calc(var(--space-unit) * 1);
    font-weight: bold;
  }
  
  .alert-success {
    background-color: #f0fff4;
    border-left: 3px solid #28a745;
  }
  
  /* Post Creation Card */
  .create-post-card {
    background-color: white;
    border-radius: var(--card-radius);
    box-shadow: var(--shadow-soft);
    margin-bottom: calc(var(--space-unit) * 3);
    overflow: hidden;
  }
  
  .post-compose {
    display: flex;
    align-items: center;
    padding: calc(var(--space-unit) * 2);
  }
  
  .user-avatar {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    margin-right: calc(var(--space-unit) * 1.5);
    object-fit: cover;
  }
  
  .compose-input-wrapper {
    flex: 1;
  }
  
  .compose-input {
    width: 100%;
    padding: calc(var(--space-unit) * 1.25);
    border-radius: 24px;
    border: 1px solid var(--border-light);
    font-size: 1rem;
    background-color: var(--bg-color);
    transition: all 0.2s ease;
  }
  
  .compose-input:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 2px rgba(74, 111, 165, 0.1);
    background-color: white;
  }
  
  .compose-actions {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: calc(var(--space-unit) * 1.5) calc(var(--space-unit) * 2);
    background-color: #fafbfc;
    border-top: 1px solid var(--border-light);
  }
  
  .compose-tools {
    display: flex;
    align-items: center;
    gap: calc(var(--space-unit) * 1.5);
  }
  
  .compose-tool {
    display: flex;
    align-items: center;
    padding: calc(var(--space-unit) * 0.75) calc(var(--space-unit) * 1.25);
    border-radius: 20px;
    color: var(--text-secondary);
    background-color: transparent;
    transition: all 0.2s ease;
    cursor: pointer;
    font-size: 0.9rem;
  }
  
  .compose-tool:hover {
    background-color: rgba(74, 111, 165, 0.08);
    color: var(--primary-color);
  }
  
  .compose-tool i {
    margin-right: calc(var(--space-unit) * 0.5);
  }
  
  .category-dropdown select {
    padding: calc(var(--space-unit) * 0.75) calc(var(--space-unit) * 1.25);
    border: 1px solid var(--border-light);
    border-radius: 20px;
    background-color: white;
    color: var(--text-secondary);
    font-size: 0.9rem;
    cursor: pointer;
  }
  
  /* Post Cards */
  .feed-posts {
    display: flex;
    flex-direction: column;
    gap: calc(var(--space-unit) * 2);
  }
  
  .post-card {
    background-color: white;
    border-radius: var(--card-radius);
    box-shadow: var(--shadow-soft);
    overflow: hidden;
  }
  
  .post-card.highlighted {
    border-left: 3px solid var(--primary-color);
  }
  
  .post-header {
    display: flex;
    align-items: center;
    padding: calc(var(--space-unit) * 2);
    padding-bottom: calc(var(--space-unit) * 1);
  }
  
  .post-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    flex-shrink: 0;
  }
  
  .post-meta-data {
    flex: 1;
    margin-left: calc(var(--space-unit) * 1.5);
    min-width: 0;
  }
  
  .author-name {
    font-size: 1rem;
    font-weight: 600;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: calc(var(--space-unit) * 0.75);
  }
  
  .author-link {
    color: var(--text-primary);
    text-decoration: none;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  
  .author-link:hover {
    text-decoration: underline;
  }
  
  .post-category-label {
    display: inline-flex;
    align-items: center;
    padding: 0 calc(var(--space-unit) * 0.75);
    height: 24px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
    white-space: nowrap;
    background-color: #f0f4f9;
    color: var(--text-secondary);
    gap: 4px; /* Added gap for better spacing between icon and text */
  }
  
  .category {
    margin-right: calc(var(--space-unit) * 0.5);
  }
  
  .category.announcement { color: #e67e22; }
  .category.help { color: #3498db; }
  .category.recommendation { color: #2ecc71; }
  .category.alert { color: #e74c3c; }
  .category.safety-alert { 
    color: #e74c3c; 
    background-color: rgba(231, 76, 60, 0.1);
    padding: 2px 6px;
    border-radius: 4px;
  }
  .category.lost-found { color: #9b59b6; }
  
  .post-time {
    font-size: 0.8rem;
    color: var(--text-secondary);
    margin-top: 2px;
  }
  
  .post-menu {
    flex-shrink: 0;
  }
  
  .menu-trigger {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: none;
    background-color: transparent;
    color: var(--text-secondary);
    cursor: pointer;
    transition: background-color 0.2s ease;
  }
  
  .menu-trigger:hover {
    background-color: rgba(0, 0, 0, 0.05);
    color: var(--text-primary);
  }
  
  .menu-dropdown {
    position: absolute;
    right: calc(var(--space-unit) * 2);
    background-color: white;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    z-index: 10;
    min-width: 150px;
    overflow: hidden;
  }
  
  .menu-dropdown a {
    display: block;
    padding: calc(var(--space-unit) * 1) calc(var(--space-unit) * 1.5);
    color: var(--text-primary);
    text-decoration: none;
    transition: background-color 0.2s ease;
    font-size: 0.9rem;
  }
  
  .menu-dropdown a:hover {
    background-color: #f5f7fa;
  }
  
  .menu-dropdown a i {
    margin-right: calc(var(--space-unit) * 1);
    color: var(--text-secondary);
    width: 16px;
    text-align: center;
  }
  
  .post-content {
    padding: 0 calc(var(--space-unit) * 2) calc(var(--space-unit) * 2);
  }
  
  .post-text {
    font-size: 1rem;
    line-height: 1.5;
    margin: 0 0 calc(var(--space-unit) * 1.5);
    color: var(--text-primary);
  }
  
  .post-media {
    border-radius: 8px;
    overflow: hidden;
    margin-top: calc(var(--space-unit) * 1);
  }
  
  .post-media img {
    width: 100%;
    height: auto;
    max-height: 600px;
    object-fit: cover;
    vertical-align: middle;
    transition: transform 0.3s ease;
  }
  
  .post-media:hover img {
    transform: scale(1.01);
  }
  
  .post-engagement {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: calc(var(--space-unit) * 1.25) calc(var(--space-unit) * 2);
    border-top: 1px solid var(--border-light);
  }
  
  .engagement-stats {
    display: flex;
    gap: calc(var(--space-unit) * 2);
    font-size: 0.9rem;
    color: var(--text-secondary);
  }
  
  .likes-count i,
  .comments-count i {
    margin-right: calc(var(--space-unit) * 0.5);
    font-size: 0.85rem;
  }
  
  .engagement-actions {
    display: flex;
    gap: calc(var(--space-unit) * 1);
  }
  
  .engagement-btn {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    border: none;
    background-color: transparent;
    color: var(--text-secondary);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    font-size: 0.9rem;
  }
  
  .engagement-btn:hover {
    background-color: rgba(0, 0, 0, 0.05);
    color: var(--text-primary);
  }
  
  .engagement-btn.like:hover { color: #4267B2; }
  .engagement-btn.comment:hover { color: #1DA1F2; }
  .engagement-btn.share:hover { color: #25D366; }
  
  /* Empty state */
  .empty-feed {
    margin-top: calc(var(--space-unit) * 3);
  }
  
  .empty-state {
    background-color: white;
    border-radius: var(--card-radius);
    padding: calc(var(--space-unit) * 4) calc(var(--space-unit) * 2);
    text-align: center;
    box-shadow: var(--shadow-soft);
  }
  
  .empty-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background-color: rgba(74, 111, 165, 0.1);
    margin-bottom: calc(var(--space-unit) * 2);
  }
  
  .empty-icon i {
    font-size: 2rem;
    color: var(--primary-color);
  }
  
  .empty-state h3 {
    font-size: 1.25rem;
    font-weight: 700;
    margin: 0 0 calc(var(--space-unit) * 1);
    color: var(--text-primary);
  }
  
  .empty-state p {
    color: var(--text-secondary);
    margin: 0 0 calc(var(--space-unit) * 3);
    max-width: 400px;
    margin-left: auto;
    margin-right: auto;
  }
  
  /* Section divider */
  .section-divider {
    position: relative;
    text-align: center;
    margin: calc(var(--space-unit) * 3) 0;
    height: 1px;
    background-color: var(--border-light);
  }
  
  .section-divider span {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: var(--bg-color);
    padding: 0 calc(var(--space-unit) * 2);
    font-size: 0.9rem;
    font-weight: 500;
    color: var(--text-secondary);
  }
  
  /* Pagination */
  .pagination-wrap {
    margin-top: calc(var(--space-unit) * 3);
    display: flex;
    justify-content: center;
  }
  
  /* Left Sidebar */
  .sidebar-section {
    background-color: white;
    border-radius: var(--card-radius);
    box-shadow: var(--shadow-soft);
    margin-bottom: calc(var(--space-unit) * 2);
    overflow: hidden;
    display: block;
  }
  
  .sidebar-title {
    font-size: 0.95rem;
    font-weight: 600;
    padding: calc(var(--space-unit) * 1.5) calc(var(--space-unit) * 2);
    margin: 0;
    color: var(--text-primary);
    border-bottom: 1px solid var(--border-light);
    background-color: #fafbfc;
  }
  
  .category-list {
    list-style: none;
    padding: 0;
    margin: 0;
  }
  
  .category-item {
    display: flex;
    align-items: center;
    padding: calc(var(--space-unit) * 1.25) calc(var(--space-unit) * 2);
    font-size: 0.95rem;
    color: var(--text-secondary);
    border-bottom: 1px solid var(--border-light);
    cursor: pointer;
    transition: all 0.2s ease;
  }
  
  .category-item:last-child {
    border-bottom: none;
  }
  
  .category-item i {
    margin-right: calc(var(--space-unit) * 1.25);
    font-size: 0.9rem;
    width: 20px;
    text-align: center;
  }
  
  .category-item span {
    flex: 1;
  }
  
  .category-count {
    font-size: 0.85rem;
    background-color: #f0f4f9;
    color: var(--text-secondary);
    width: 24px;
    height: 20px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  
  .category-item.active {
    color: var(--primary-color);
    background-color: rgba(74, 111, 165, 0.05);
    font-weight: 500;
  }
  
  .category-item:hover:not(.active) {
    background-color: #f5f7fa;
  }
  
  .quick-links {
    list-style: none;
    padding: calc(var(--space-unit) * 1.25) 0;
    margin: 0;
  }
  
  .quick-links li {
    padding: calc(var(--space-unit) * 0.75) calc(var(--space-unit) * 2);
  }
  
  .quick-links a {
    color: var(--text-secondary);
    text-decoration: none;
    font-size: 0.95rem;
    transition: color 0.2s ease;
  }
  
  .quick-links a:hover {
    color: var(--primary-color);
  }
  
  .quick-links i {
    margin-right: calc(var(--space-unit) * 1);
    font-size: 0.9rem;
    width: 20px;
    text-align: center;
  }
  
  .tag-cloud {
    padding: calc(var(--space-unit) * 1.25) calc(var(--space-unit) * 2);
    display: flex;
    flex-wrap: wrap;
    gap: calc(var(--space-unit) * 0.75);
  }
  
  .tag {
    display: inline-block;
    padding: calc(var(--space-unit) * 0.5) calc(var(--space-unit) * 1);
    background-color: #f0f4f9;
    border-radius: 4px;
    color: var(--text-secondary);
    font-size: 0.85rem;
    text-decoration: none;
    transition: all 0.2s ease;
  }
  
  .tag:hover {
    background-color: rgba(74, 111, 165, 0.1);
    color: var(--primary-color);
  }
  
  /* Right Sidebar */
  .panel {
    background-color: white;
    border-radius: var(--card-radius);
    box-shadow: var(--shadow-soft);
    margin-bottom: calc(var(--space-unit) * 2);
    overflow: hidden;
    display: block;
  }
  
  .panel-header {
    padding: calc(var(--space-unit) * 1.5) calc(var(--space-unit) * 2);
    border-bottom: 1px solid var(--border-light);
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #fafbfc;
  }
  
  .panel-header h3 {
    margin: 0;
    font-size: 0.95rem;
    font-weight: 600;
    color: var(--text-primary);
  }
  
  .panel-header h3 i {
    margin-right: calc(var(--space-unit) * 0.75);
    color: var(--primary-color);
  }
  
  .view-all {
    font-size: 0.8rem;
    color: var(--primary-color);
    text-decoration: none;
  }
  
  .view-all:hover {
    text-decoration: underline;
  }
  
  .panel-body {
    padding: calc(var(--space-unit) * 1.5) calc(var(--space-unit) * 2);
    display: block;
  }
  
  /* Contributors */
  .contributor-rankings {
    display: flex;
    flex-direction: column;
    gap: calc(var(--space-unit) * 1);
  }
  
  .contributor-card {
    display: flex;
    align-items: center;
    padding: calc(var(--space-unit) * 1) 0;
    border-bottom: 1px solid var(--border-light);
    position: relative;
  }
  
  .contributor-card:last-child {
    border-bottom: none;
    padding-bottom: 0;
  }
  
  .contributor-rank {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background-color: #f0f4f9;
    color: var(--text-secondary);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
    font-weight: 600;
    margin-right: calc(var(--space-unit) * 1.25);
  }
  
  .contributor-image {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    object-fit: cover;
    margin-right: calc(var(--space-unit) * 1.25);
  }
  
  .contributor-details {
    flex: 1;
    min-width: 0;
  }
  
  .contributor-name {
    font-size: 0.9rem;
    font-weight: 500;
    margin: 0 0 2px;
    color: var(--text-primary);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  
  .contributor-stats {
    font-size: 0.8rem;
    color: var(--text-secondary);
  }
  
  /* Stats */
  .stats-container {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: calc(var(--space-unit) * 1);
  }
  
  .stat-box {
    background-color: #f0f4f9;
    border-radius: 8px;
    padding: calc(var(--space-unit) * 1.5);
    text-align: center;
    position: relative;
    overflow: hidden;
  }
  
  .stat-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: calc(var(--space-unit) * 0.5);
  }
  
  .stat-label {
    font-size: 0.75rem;
    color: var(--text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
  
  .stat-icon {
    position: absolute;
    bottom: -5px;
    right: -5px;
    font-size: 2.5rem;
    color: rgba(0, 0, 0, 0.05);
    transform: rotate(-10deg);
  }
  
  /* Events */
  .events-list {
    display: flex;
    flex-direction: column;
    gap: calc(var(--space-unit) * 1.5);
  }
  
  .event-card {
    display: flex;
    align-items: center;
    gap: calc(var(--space-unit) * 1.5);
  }
  
  .event-date {
    width: 50px;
    height: 55px;
    background-color: var(--primary-color);
    color: white;
    text-align: center;
    border-radius: 8px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    flex-shrink: 0;
  }
  
  .event-day {
    font-size: 1.25rem;
    font-weight: 700;
    line-height: 1;
  }
  
  .event-month {
    font-size: 0.75rem;
    text-transform: uppercase;
    margin-top: 2px;
  }
  
  .event-details {
    flex: 1;
    min-width: 0;
  }
  
  .event-title {
    font-size: 0.9rem;
    font-weight: 600;
    margin: 0 0 calc(var(--space-unit) * 0.5);
    color: var(--text-primary);
  }
  
  .event-meta {
    display: flex;
    flex-direction: column;
    font-size: 0.75rem;
    color: var(--text-secondary);
    gap: 2px;
  }
  
  .event-meta span {
    display: flex;
    align-items: center;
  }
  
  .event-meta i {
    width: 12px;
    margin-right: calc(var(--space-unit) * 0.5);
    text-align: center;
  }
  
  /* Guidelines */
  .guidelines-list {
    list-style: none;
    padding: 0;
    margin: 0 0 calc(var(--space-unit) * 2);
  }
  
  .guidelines-list li {
    display: flex;
    align-items: center;
    padding: calc(var(--space-unit) * 1) 0;
    border-bottom: 1px solid var(--border-light);
    font-size: 0.9rem;
    color: var(--text-primary);
  }
  
  .guidelines-list li:last-child {
    border-bottom: none;
  }
  
  .guidelines-list li i {
    color: var(--primary-color);
    margin-right: calc(var(--space-unit) * 1);
    font-size: 0.8rem;
    width: 16px;
    text-align: center;
  }
  
  .btn-outline {
    display: block;
    width: 100%;
    padding: calc(var(--space-unit) * 1) 0;
    text-align: center;
    border: 1px solid var(--primary-color);
    color: var(--primary-color);
    border-radius: 6px;
    background-color: transparent;
    transition: all 0.2s ease;
    text-decoration: none;
    font-weight: 500;
    font-size: 0.9rem;
  }
  
  .btn-outline:hover {
    background-color: rgba(74, 111, 165, 0.05);
  }
  
  /* Mobile adjustments */
  .mobile-post-button,
  .mobile-categories {
    display: none;
  }
  
  @media (max-width: 1200px) {
    .community-layout {
      grid-template-columns: 200px 1fr 250px;
      gap: calc(var(--space-unit) * 1.5);
    }
  }
  
  @media (max-width: 992px) {
    .community-layout {
      grid-template-columns: 1fr 250px;
    }
    
    .left-sidebar {
      display: none;
    }
    
    .feed-main {
      grid-column: 1;
    }
    
    .right-sidebar {
      grid-column: 2;
    }
    
    .mobile-post-button {
      display: block;
      margin-bottom: calc(var(--space-unit) * 2);
    }
    
    .mobile-categories {
      display: flex;
      padding: calc(var(--space-unit) * 0.5) 0;
      overflow-x: auto;
      gap: calc(var(--space-unit) * 1);
      -webkit-overflow-scrolling: touch;
      scrollbar-width: none;
    }
    
    .mobile-categories::-webkit-scrollbar {
      display: none;
    }
    
    .category-pill {
      flex-shrink: 0;
      padding: calc(var(--space-unit) * 0.75) calc(var(--space-unit) * 1.5);
      border-radius: 20px;
      background-color: #f0f4f9;
      color: var(--text-secondary);
      font-size: 0.9rem;
      border: none;
      cursor: pointer;
    }
    
    .category-pill.active {
      background-color: var(--primary-color);
      color: white;
    }
  }
  
  @media (max-width: 768px) {
    .community-layout {
      display: flex;
      flex-direction: column;
    }
    
    .right-sidebar {
      margin-top: calc(var(--space-unit) * 3);
    }
    
    .search-filter-bar {
      flex-direction: column;
      gap: calc(var(--space-unit) * 1);
    }
    
    .filter-pills {
      width: 100%;
      justify-content: space-between;
    }
    
    .post-header {
      padding: calc(var(--space-unit) * 1.5) calc(var(--space-unit) * 1.5) calc(var(--space-unit) * 0.5);
    }
    
    .post-content {
      padding: 0 calc(var(--space-unit) * 1.5) calc(var(--space-unit) * 1.5);
    }
    
    .post-engagement {
      padding: calc(var(--space-unit) * 1) calc(var(--space-unit) * 1.5);
    }
    
    .engagement-stats {
      display: none;
    }
    
    .engagement-actions {
      width: 100%;
      justify-content: space-around;
    }
  }
</style>
@endsection

@section('content')
<main class="community-page">
  <!-- Sticky Navigation Bar -->
  <div class="community-nav">
    <div class="container nav-container">
      <div class="community-heading">
        <h1>Community Feed</h1>
        <button class="btn btn-primary" id="createPostBtn">
          <i class="fas fa-plus-circle"></i> Create Post
        </button>
      </div>
      
      <div class="sort-controls">
        <div class="filter-pills">
          <button class="filter-pill active"><i class="fas fa-clock"></i> Latest</button>
          <button class="filter-pill"><i class="fas fa-fire"></i> Popular</button>
          <button class="filter-pill"><i class="fas fa-map-marker-alt"></i> Nearby</button>
        </div>
      </div>
    </div>
  </div>
  
  <div class="container">
    @if(session('success'))
      <div class="alert-message alert-success">
        {{ session('success') }}
      </div>
    @endif
    
    <div class="search-filter-bar">
      <div class="search-box">
        <input type="text" placeholder="Search posts, neighbors, or topics...">
        <i class="fas fa-search search-icon"></i>
      </div>
      
      <div class="filter-dropdown">
        <select class="form-control">
          <option>All Categories</option>
          <option>Announcements</option>
          <option>Help Requests</option>
          <option>Recommendations</option>
          <option>Safety Alerts</option>
          <option>Lost & Found</option>
        </select>
      </div>
    </div>
    
    <!-- Mobile only categories -->
    <div class="mobile-categories">
      <button class="category-pill active">All</button>
      <button class="category-pill">Announcements</button>
      <button class="category-pill">Help Requests</button>
      <button class="category-pill">Recommendations</button>
      <button class="category-pill">Safety Alerts</button>
      <button class="category-pill">Lost & Found</button>
    </div>
    
    <div class="community-layout">
      <!-- Left Sidebar -->
      <div class="left-sidebar">
        <div class="sidebar-section">
          <h3 class="sidebar-title">Categories</h3>
          <ul class="category-list">
            <li class="category-item active">
              <i class="fas fa-layer-group"></i> 
              <span>All Posts</span>
              <span class="category-count">350</span>
            </li>
            <li class="category-item">
              <i class="fas fa-bullhorn"></i> 
              <span>Announcements</span>
              <span class="category-count">42</span>
            </li>
            <li class="category-item">
              <i class="fas fa-hands-helping"></i> 
              <span>Help Requests</span>
              <span class="category-count">78</span>
            </li>
            <li class="category-item">
              <i class="fas fa-thumbs-up"></i> 
              <span>Recommendations</span>
              <span class="category-count">53</span>
            </li>
            <li class="category-item">
              <i class="fas fa-exclamation-triangle"></i> 
              <span>Safety Alerts</span>
              <span class="category-count">16</span>
            </li>
            <li class="category-item">
              <i class="fas fa-search"></i> 
              <span>Lost & Found</span>
              <span class="category-count">29</span>
            </li>
          </ul>
        </div>
        
        <div class="sidebar-section">
          <h3 class="sidebar-title">Quick Links</h3>
          <ul class="quick-links">
            <li><i class="fas fa-calendar-alt"></i> <a href="{{ route('events.index') }}">Events</a></li>
            <li><i class="fas fa-shopping-cart"></i> <a href="{{ route('marketplace.index') }}">Marketplace</a></li>
            <li><i class="fas fa-users"></i> <a href="#">Neighbors</a></li>
            <li><i class="fas fa-question-circle"></i> <a href="#">Help Center</a></li>
          </ul>
        </div>
        
        <div class="sidebar-section">
          <h3 class="sidebar-title">Trending Tags</h3>
          <div class="tag-cloud">
            <a href="#" class="tag">#BlockParty</a>
            <a href="#" class="tag">#PetAdoption</a>
            <a href="#" class="tag">#Gardening</a>
            <a href="#" class="tag">#TrafficAlert</a>
            <a href="#" class="tag">#LocalBusiness</a>
            <a href="#" class="tag">#SchoolNews</a>
          </div>
        </div>
      </div>
      
      <!-- Main Content Area -->
      <div class="feed-main">
        <div class="create-post-card">
          <form action="{{ route('community.post.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="post-compose">
              <img src="{{ user_avatar(Auth::user()) }}" alt="{{ Auth::user()->name }}" class="user-avatar">
              <div class="compose-input-wrapper">
                <input type="text" name="content" placeholder="What's happening in the neighborhood?" class="compose-input" required>
              </div>
            </div>
            
            <div class="compose-actions">
              <div class="compose-tools">
                <label for="image-upload" class="compose-tool">
                  <i class="fas fa-image"></i>
                  <span>Photo</span>
                </label>
                <input id="image-upload" type="file" name="image" class="hidden">
                
                <label class="compose-tool">
                  <i class="fas fa-map-marker-alt"></i>
                  <span>Location</span>
                </label>
                
                <div class="category-dropdown">
                  <select name="category" class="form-control">
                    <option value="">Select category</option>
                    <option value="Announcement">📢 Announcement</option>
                    <option value="Help Request">🤝 Help Request</option>
                    <option value="Recommendation">👍 Recommendation</option>
                    <option value="Safety Alert">⚠️ Safety Alert</option>
                    <option value="Lost & Found">🔍 Lost & Found</option>
                  </select>
                </div>
              </div>
              
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-paper-plane"></i> Post
              </button>
            </div>
          </form>
        </div>
        
        <!-- Feed Posts -->
        <div class="feed-posts">
          @if($posts->isEmpty())
            <div class="empty-feed">
              <div class="empty-state">
                <div class="empty-icon"><i class="fas fa-comments"></i></div>
                <h3>No posts yet</h3>
                <p>Be the first to start a conversation in your neighborhood!</p>
                <button class="btn btn-primary" id="createFirstPost">Create Your First Post</button>
              </div>
            </div>
          @else
            @foreach($posts as $post)
              <div class="post-card">
                <!-- Post Header -->
                <div class="post-header">
                  <a href="#" class="post-author-link">
                    <img src="{{ user_avatar($post->user) }}" alt="{{ $post->user->name }}" class="post-avatar">
                  </a>
                  
                  <div class="post-meta-data">
                    <div class="author-name">
                      <a href="#" class="author-link">{{ $post->user->name }}</a>
                      @if($post->category)
                        <span class="post-category-label">
                          @switch($post->category)
                            @case('Announcement')
                              <span class="category announcement">📢</span>
                              @break
                            @case('Help Request')
                              <span class="category help">🤝</span>
                              @break
                            @case('Recommendation')
                              <span class="category recommendation">👍</span>
                              @break
                            @case('Safety Alert')
                              <span class="category safety-alert">⚠️</span>
                              @break
                            @case('Lost & Found')
                              <span class="category lost-found">🔍</span>
                              @break
                            @default
                              <span class="category">📌</span>
                          @endswitch
                          {{ $post->category }}
                        </span>
                      @endif
                    </div>
                    <div class="post-time">{{ $post->created_at->diffForHumans() }}</div>
                  </div>
                  
                  <div class="post-menu">
                    <button class="menu-trigger">
                      <i class="fas fa-ellipsis-h"></i>
                    </button>
                    <div class="menu-dropdown hidden">
                      @if(Auth::id() == $post->user_id)
                        <a href="{{ route('community.post.edit', $post->id) }}"><i class="fas fa-edit"></i> Edit Post</a>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('delete-post-{{ $post->id }}').submit();"><i class="fas fa-trash"></i> Delete Post</a>
                        <form id="delete-post-{{ $post->id }}" action="{{ route('community.post.destroy', $post->id) }}" method="POST" style="display: none;">
                          @csrf
                          @method('DELETE')
                        </form>
                      @endif
                      <a href="#"><i class="fas fa-flag"></i> Report Post</a>
                      <a href="#"><i class="fas fa-share"></i> Share Post</a>
                    </div>
                  </div>
                </div>
                
                <!-- Post Content -->
                <div class="post-content">
                  <p class="post-text">{{ $post->content }}</p>
                  
                  @if($post->image)
                    <div class="post-media">
                      <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image">
                    </div>
                  @endif
                </div>
                
                <!-- Post Footer -->
                <div class="post-engagement">
                  <div class="engagement-stats">
                    <span class="likes-count">
                      <i class="fas fa-thumbs-up"></i> {{ $post->likes_count ?? 0 }}
                    </span>
                    <span class="comments-count">
                      <i class="fas fa-comment"></i> {{ $post->comments_count ?? 0 }}
                    </span>
                  </div>
                  
                  <div class="engagement-actions">
                    <button class="engagement-btn like">
                      <i class="far fa-thumbs-up"></i>
                    </button>
                    <button class="engagement-btn comment">
                      <i class="far fa-comment"></i>
                    </button>
                    <button class="engagement-btn share">
                      <i class="fas fa-share"></i>
                    </button>
                  </div>
                </div>
              </div>
            @endforeach
            
            <!-- Pagination -->
            <div class="pagination-wrap">
              {{ $posts->links() }}
            </div>
          @endif
        </div>
        
        <!-- Sample Posts (when empty) -->
        @if($posts->isEmpty())
          <div class="sample-post-section">
            <div class="section-divider">
              <span>Sample Posts</span>
            </div>
            
            <!-- First Sample Post -->
            <div class="post-card highlighted">
              <div class="post-header">
                <a href="#" class="post-author-link">
                  <img src="{{ user_avatar(null) }}" alt="Sarah J." class="post-avatar">
                </a>
                
                <div class="post-meta-data">
                  <div class="author-name">
                    <a href="#" class="author-link">Sarah Johnson</a>
                    <span class="post-category-label">
                      <span class="category announcement">📢</span>
                      Announcement
                    </span>
                  </div>
                  <div class="post-time">2 hours ago</div>
                </div>
                
                <div class="post-menu">
                  <button class="menu-trigger">
                    <i class="fas fa-ellipsis-h"></i>
                  </button>
                </div>
              </div>
              
              <div class="post-content">
                <p class="post-text">Our annual block party is coming up next Saturday! Please RSVP so we can plan accordingly. There will be food, games, and music for all ages.</p>
                <div class="post-media">
                  <img src="https://images.unsplash.com/photo-1511795409834-ef04bbd61622?auto=format&fit=crop&w=800&q=80" alt="Block Party" loading="lazy">
                </div>
              </div>
              
              <div class="post-engagement">
                <div class="engagement-stats">
                  <span class="likes-count">
                    <i class="fas fa-thumbs-up"></i> 12
                  </span>
                  <span class="comments-count">
                    <i class="fas fa-comment"></i> 5
                  </span>
                </div>
                
                <div class="engagement-actions">
                  <button class="engagement-btn like">
                    <i class="far fa-thumbs-up"></i>
                  </button>
                  <button class="engagement-btn comment">
                    <i class="far fa-comment"></i>
                  </button>
                  <button class="engagement-btn share">
                    <i class="fas fa-share"></i>
                  </button>
                </div>
              </div>
            </div>
            
            <!-- Second Sample Post -->
            <div class="post-card">
              <div class="post-header">
                <a href="#" class="post-author-link">
                  <img src="{{ user_avatar(null) }}" alt="John D." class="post-avatar">
                </a>
                
                <div class="post-meta-data">
                  <div class="author-name">
                    <a href="#" class="author-link">John Doe</a>
                    <span class="post-category-label">
                      <span class="category help">🤝</span>
                      Help Request
                    </span>
                  </div>
                  <div class="post-time">5 hours ago</div>
                </div>
                
                <div class="post-menu">
                  <button class="menu-trigger">
                    <i class="fas fa-ellipsis-h"></i>
                  </button>
                </div>
              </div>
              
              <div class="post-content">
                <p class="post-text">Does anyone have a ladder I could borrow for a day? Need to clean my gutters. Will return it the same day!</p>
              </div>
              
              <div class="post-engagement">
                <div class="engagement-stats">
                  <span class="likes-count">
                    <i class="fas fa-thumbs-up"></i> 8
                  </span>
                  <span class="comments-count">
                    <i class="fas fa-comment"></i> 3
                  </span>
                </div>
                
                <div class="engagement-actions">
                  <button class="engagement-btn like">
                    <i class="far fa-thumbs-up"></i>
                  </button>
                  <button class="engagement-btn comment">
                    <i class="far fa-comment"></i>
                  </button>
                  <button class="engagement-btn share">
                    <i class="fas fa-share"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
        @endif
      </div>
      
      <!-- Right Sidebar -->
      <div class="right-sidebar">
        <!-- Create Post Button for Mobile -->
        <div class="mobile-post-button">
          <button class="btn btn-primary w-100" id="mobileCreatePostBtn">
            <i class="fas fa-plus-circle"></i> Create New Post
          </button>
        </div>
        
        <!-- Top Contributors Panel -->
        <section class="panel" id="top-contributors">
          <div class="panel-header">
            <h3><i class="fas fa-award"></i> Top Contributors</h3>
            <a href="#" class="view-all">View All →</a>
          </div>
          <div class="panel-body">
            <div class="contributor-rankings">
              @forelse($topContributors as $contributor)
                <div class="contributor-card">
                  <div class="contributor-rank">#{{ $loop->iteration }}</div>
                  <img src="{{ user_avatar($contributor) }}" alt="{{ $contributor->name }}" class="contributor-image">
                  <div class="contributor-details">
                    <h4 class="contributor-name">{{ $contributor->name }}</h4>
                    <div class="contributor-stats">{{ $contributor->posts_count }} posts</div>
                  </div>
                </div>
              @empty
                <!-- Sample contributors for when database is empty -->
                <div class="contributor-card">
                  <div class="contributor-rank">#1</div>
                  <img src="{{ user_avatar(null) }}" alt="John Doe" class="contributor-image">
                  <div class="contributor-details">
                    <h4 class="contributor-name">John Doe</h4>
                    <div class="contributor-stats">42 posts</div>
                  </div>
                </div>
                <div class="contributor-card">
                  <div class="contributor-rank">#2</div>
                  <img src="{{ user_avatar(null) }}" alt="Jane Doe" class="contributor-image">
                  <div class="contributor-details">
                    <h4 class="contributor-name">Jane Doe</h4>
                    <div class="contributor-stats">35 posts</div>
                  </div>
                </div>
                <div class="contributor-card">
                  <div class="contributor-rank">#3</div>
                  <img src="{{ user_avatar(null) }}" alt="Nick Doe" class="contributor-image">
                  <div class="contributor-details">
                    <h4 class="contributor-name">Nick Doe</h4>
                    <div class="contributor-stats">28 posts</div>
                  </div>
                </div>
              @endforelse
            </div>
          </div>
        </section>
        
        <!-- Neighborhood Stats Panel -->
        <section class="panel" id="neighborhood-stats">
          <div class="panel-header">
            <h3><i class="fas fa-chart-bar"></i> Neighborhood Stats</h3>
          </div>
          <div class="panel-body">
            <div class="stats-container">
              <div class="stat-box">
                <div class="stat-value">1,235</div>
                <div class="stat-label">Members</div>
                <i class="fas fa-users stat-icon"></i>
              </div>
              <div class="stat-box">
                <div class="stat-value">56</div>
                <div class="stat-label">Events</div>
                <i class="fas fa-calendar stat-icon"></i>
              </div>
              <div class="stat-box">
                <div class="stat-value">78%</div>
                <div class="stat-label">Participation</div>
                <i class="fas fa-chart-line stat-icon"></i>
              </div>
            </div>
          </div>
        </section>
        
        <!-- Community Guidelines Panel -->
        <section class="panel" id="community-guidelines">
          <div class="panel-header">
            <h3><i class="fas fa-scroll"></i> Community Guidelines</h3>
          </div>
          <div class="panel-body">
            <ul class="guidelines-list">
              <li><i class="fas fa-check"></i> Be respectful to fellow neighbors</li>
              <li><i class="fas fa-check"></i> Share helpful and relevant information</li>
              <li><i class="fas fa-check"></i> Verify facts before posting alerts</li>
              <li><i class="fas fa-check"></i> Keep discussions friendly and constructive</li>
            </ul>
            <a href="#" class="btn-outline">Read Full Guidelines</a>
          </div>
        </section>
        
        <!-- Upcoming Events Panel -->
        <section class="panel" id="upcoming-events">
          <div class="panel-header">
            <h3><i class="fas fa-calendar-day"></i> Upcoming Events</h3>
            <a href="{{ route('events.index') }}" class="view-all">View All →</a>
          </div>
          <div class="panel-body">
            <div class="events-list">
              <div class="event-card">
                <div class="event-date">
                  <div class="event-day">25</div>
                  <div class="event-month">AUG</div>
                </div>
                <div class="event-details">
                  <h4 class="event-title">Summer Block Party</h4>
                  <div class="event-meta">
                    <span><i class="fas fa-map-marker-alt"></i> Central Park</span>
                    <span><i class="fas fa-clock"></i> 3:00 PM</span>
                  </div>
                </div>
              </div>
              <div class="event-card">
                <div class="event-date">
                  <div class="event-day">02</div>
                  <div class="event-month">SEP</div>
                </div>
                <div class="event-details">
                  <h4 class="event-title">Neighborhood Cleanup</h4>
                  <div class="event-meta">
                    <span><i class="fas fa-map-marker-alt"></i> Main Street</span>
                    <span><i class="fas fa-clock"></i> 10:00 AM</span>
                  </div>
                </div>
              </div>
              <div class="event-card">
                <div class="event-date">
                  <div class="event-day">10</div>
                  <div class="event-month">SEP</div>
                </div>
                <div class="event-details">
                  <h4 class="event-title">Community Garden Day</h4>
                  <div class="event-meta">
                    <span><i class="fas fa-map-marker-alt"></i> Garden Square</span>
                    <span><i class="fas fa-clock"></i> 9:00 AM</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Toggle filter pill selection
  document.querySelectorAll('.filter-pill').forEach(pill => {
    pill.addEventListener('click', function() {
      document.querySelectorAll('.filter-pill').forEach(p => {
        p.classList.remove('active');
      });
      this.classList.add('active');
    });
  });
  
  // Toggle category selection in left sidebar
  document.querySelectorAll('.category-item').forEach(item => {
    item.addEventListener('click', function() {
      document.querySelectorAll('.category-item').forEach(i => {
        i.classList.remove('active');
      });
      this.classList.add('active');
    });
  });
  
  // Toggle mobile category pills
  document.querySelectorAll('.category-pill').forEach(pill => {
    pill.addEventListener('click', function() {
      document.querySelectorAll('.category-pill').forEach(p => {
        p.classList.remove('active');
      });
      this.classList.add('active');
    });
  });
  
  // Post menu dropdowns
  document.querySelectorAll('.menu-trigger').forEach(btn => {
    btn.addEventListener('click', function(e) {
      e.stopPropagation();
      const dropdown = this.parentElement.querySelector('.menu-dropdown');
      if (dropdown) {
        dropdown.classList.toggle('hidden');
      }
      
      // Close other dropdowns
      document.querySelectorAll('.menu-dropdown:not(.hidden)').forEach(dd => {
        if (dd !== dropdown) {
          dd.classList.add('hidden');
        }
      });
    });
  });
  
  // Close dropdowns on click outside
  document.addEventListener('click', function() {
    document.querySelectorAll('.menu-dropdown:not(.hidden)').forEach(dd => {
      dd.classList.add('hidden');
    });
  });
  
  // Create post button (for mobile)
  const mobileCreatePostBtn = document.getElementById('mobileCreatePostBtn');
  if (mobileCreatePostBtn) {
    mobileCreatePostBtn.addEventListener('click', function() {
      document.querySelector('.compose-input').focus();
      window.scrollTo({
        top: document.querySelector('.create-post-card').offsetTop - 70,
        behavior: 'smooth'
      });
    });
  }
  
  // Create first post button in empty state
  const createFirstPostBtn = document.getElementById('createFirstPost');
  if (createFirstPostBtn) {
    createFirstPostBtn.addEventListener('click', function() {
      document.querySelector('.compose-input').focus();
      window.scrollTo({
        top: document.querySelector('.create-post-card').offsetTop - 70,
        behavior: 'smooth'
      });
    });
  }
  
  // File input preview
  const imageUpload = document.getElementById('image-upload');
  if (imageUpload) {
    imageUpload.addEventListener('change', function() {
      if (this.files.length > 0) {
        const label = document.querySelector('label[for="image-upload"]');
        label.innerHTML = '<i class="fas fa-check"></i> Photo Selected';
        label.style.backgroundColor = 'rgba(46, 204, 113, 0.1)';
        label.style.color = '#2ecc71';
      }
    });
  }
});
</script>
@endsection
