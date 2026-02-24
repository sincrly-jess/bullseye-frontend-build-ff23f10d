const Footer = () => (
  <footer className="py-10 bg-card border-t border-border">
    <div className="container mx-auto px-4">
      <div className="flex flex-col md:flex-row items-center justify-between gap-4">
        <div className="flex items-center gap-2">
          <div className="w-7 h-7 rounded-full bg-primary flex items-center justify-center">
            <span className="font-display text-primary-foreground text-xs font-bold">B</span>
          </div>
          <span className="font-display text-sm font-bold tracking-wider text-foreground">BULLSEYE</span>
        </div>
        <div className="flex items-center gap-6 text-sm text-muted-foreground">
          <a href="#" className="hover:text-foreground transition-colors">Terms</a>
          <a href="#" className="hover:text-foreground transition-colors">Privacy</a>
          <a href="#" className="hover:text-foreground transition-colors">Support</a>
          <a href="#" className="hover:text-foreground transition-colors">Contact</a>
        </div>
        <span className="text-xs text-muted-foreground">© 2026 Bullseye. All rights reserved.</span>
      </div>
    </div>
  </footer>
);

export default Footer;
