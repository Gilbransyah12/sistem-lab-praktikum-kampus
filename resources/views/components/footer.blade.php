<footer class="app-footer">
    <div class="footer-content">
        <div class="footer-left">
            <span class="footer-brand">
                <i class="fas fa-flask"></i>
                Lab Praktikum UMPAR
            </span>
        </div>
        <div class="footer-center">
            <span>&copy; {{ date('Y') }} All rights reserved.</span>
        </div>
        <div class="footer-right">
            <span class="footer-version">v1.0.0</span>
        </div>
    </div>
</footer>

<style>
.app-footer {
    background: white;
    border-top: 1px solid var(--dark-100);
    padding: 1rem 1.5rem;
    margin-top: auto;
}

.footer-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 0.75rem;
}

.footer-brand {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--dark-700);
}

.footer-brand i {
    color: var(--primary-500);
}

.footer-center {
    font-size: 0.8125rem;
    color: var(--dark-500);
}

.footer-right {
    display: flex;
    align-items: center;
}

.footer-version {
    font-size: 0.75rem;
    padding: 0.25rem 0.625rem;
    background: var(--dark-100);
    color: var(--dark-500);
    border-radius: 9999px;
    font-weight: 500;
}

@media (max-width: 640px) {
    .footer-content {
        flex-direction: column;
        text-align: center;
    }
    
    .footer-left,
    .footer-right {
        width: 100%;
        justify-content: center;
    }
}
</style>
