@props(['type' => 'info'])

@php
    $configs = [
        'success' => [
            'gradient' => 'linear-gradient(135deg, rgba(34, 197, 94, 0.1) 0%, rgba(16, 185, 129, 0.08) 100%)',
            'border' => 'rgba(34, 197, 94, 0.25)',
            'icon_bg' => 'linear-gradient(135deg, #22c55e 0%, #10b981 100%)',
            'text' => '#059669',
            'icon' => 'fa-check-circle',
        ],
        'error' => [
            'gradient' => 'linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(248, 113, 113, 0.08) 100%)',
            'border' => 'rgba(239, 68, 68, 0.25)',
            'icon_bg' => 'linear-gradient(135deg, #ef4444 0%, #f87171 100%)',
            'text' => '#dc2626',
            'icon' => 'fa-exclamation-circle',
        ],
        'danger' => [
            'gradient' => 'linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(248, 113, 113, 0.08) 100%)',
            'border' => 'rgba(239, 68, 68, 0.25)',
            'icon_bg' => 'linear-gradient(135deg, #ef4444 0%, #f87171 100%)',
            'text' => '#dc2626',
            'icon' => 'fa-exclamation-circle',
        ],
        'warning' => [
            'gradient' => 'linear-gradient(135deg, rgba(245, 158, 11, 0.1) 0%, rgba(251, 191, 36, 0.08) 100%)',
            'border' => 'rgba(245, 158, 11, 0.25)',
            'icon_bg' => 'linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%)',
            'text' => '#d97706',
            'icon' => 'fa-exclamation-triangle',
        ],
        'info' => [
            'gradient' => 'linear-gradient(135deg, rgba(6, 182, 212, 0.1) 0%, rgba(34, 211, 238, 0.08) 100%)',
            'border' => 'rgba(6, 182, 212, 0.25)',
            'icon_bg' => 'linear-gradient(135deg, #06b6d4 0%, #22d3ee 100%)',
            'text' => '#0891b2',
            'icon' => 'fa-info-circle',
        ],
    ];
    
    $config = $configs[$type] ?? $configs['info'];
@endphp

<div class="premium-alert" style="
    background: {{ $config['gradient'] }};
    border: 1px solid {{ $config['border'] }};
    color: {{ $config['text'] }};
">
    <div class="alert-icon" style="background: {{ $config['icon_bg'] }};">
        <i class="fas {{ $config['icon'] }}"></i>
    </div>
    <div class="alert-content">{{ $slot }}</div>
    <button type="button" class="alert-close" onclick="this.parentElement.remove()">
        <i class="fas fa-times"></i>
    </button>
</div>

<style>
.premium-alert {
    display: flex;
    align-items: flex-start;
    gap: 0.875rem;
    padding: 1rem 1.25rem;
    border-radius: 0.75rem;
    margin-bottom: 1rem;
    animation: slideIn 0.3s ease-out;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.alert-icon {
    flex-shrink: 0;
    width: 32px;
    height: 32px;
    border-radius: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.875rem;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.alert-content {
    flex: 1;
    font-size: 0.9375rem;
    font-weight: 500;
    line-height: 1.5;
    padding-top: 0.25rem;
}

.alert-close {
    flex-shrink: 0;
    width: 28px;
    height: 28px;
    border: none;
    background: rgba(0, 0, 0, 0.05);
    border-radius: 0.375rem;
    color: inherit;
    opacity: 0.6;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}

.alert-close:hover {
    opacity: 1;
    background: rgba(0, 0, 0, 0.1);
}
</style>
