import { Search, Bell, User, Menu, X } from "lucide-react";
import { useState } from "react";
import { Button } from "@/components/ui/button";

const Navbar = () => {
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);

  return (
    <nav className="fixed top-0 left-0 right-0 z-50 glass border-b border-border">
      <div className="container mx-auto flex items-center justify-between h-16 px-4">
        {/* Logo */}
        <div className="flex items-center gap-2">
          <div className="w-8 h-8 rounded-full bg-primary flex items-center justify-center">
            <span className="font-display text-primary-foreground text-sm font-bold">B</span>
          </div>
          <span className="font-display text-lg font-bold tracking-wider text-foreground">
            BULLSEYE
          </span>
        </div>

        {/* Desktop Nav */}
        <div className="hidden md:flex items-center gap-6">
          <a href="#" className="text-sm text-foreground hover:text-primary transition-colors font-medium">Home</a>
          <a href="#" className="text-sm text-muted-foreground hover:text-primary transition-colors">Predictions</a>
          <a href="#" className="text-sm text-muted-foreground hover:text-primary transition-colors">Casino</a>
          <a href="#" className="text-sm text-muted-foreground hover:text-primary transition-colors">Leaderboard</a>
          <a href="#" className="text-sm text-muted-foreground hover:text-primary transition-colors">Rewards</a>
        </div>

        {/* Right side */}
        <div className="hidden md:flex items-center gap-3">
          <button className="p-2 rounded-lg text-muted-foreground hover:text-foreground hover:bg-secondary transition-colors">
            <Search className="w-5 h-5" />
          </button>
          <button className="p-2 rounded-lg text-muted-foreground hover:text-foreground hover:bg-secondary transition-colors relative">
            <Bell className="w-5 h-5" />
            <span className="absolute top-1 right-1 w-2 h-2 bg-primary rounded-full" />
          </button>
          <Button variant="outline" size="sm" className="border-border text-foreground hover:bg-secondary">
            Log In
          </Button>
          <Button size="sm" className="bg-primary text-primary-foreground hover:bg-primary/90">
            Sign Up
          </Button>
        </div>

        {/* Mobile menu toggle */}
        <button
          className="md:hidden p-2 text-foreground"
          onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
        >
          {mobileMenuOpen ? <X className="w-6 h-6" /> : <Menu className="w-6 h-6" />}
        </button>
      </div>

      {/* Mobile menu */}
      {mobileMenuOpen && (
        <div className="md:hidden glass border-t border-border px-4 pb-4 space-y-3">
          <a href="#" className="block py-2 text-foreground font-medium">Home</a>
          <a href="#" className="block py-2 text-muted-foreground">Predictions</a>
          <a href="#" className="block py-2 text-muted-foreground">Casino</a>
          <a href="#" className="block py-2 text-muted-foreground">Leaderboard</a>
          <a href="#" className="block py-2 text-muted-foreground">Rewards</a>
          <div className="flex gap-2 pt-2">
            <Button variant="outline" size="sm" className="flex-1 border-border text-foreground">Log In</Button>
            <Button size="sm" className="flex-1 bg-primary text-primary-foreground">Sign Up</Button>
          </div>
        </div>
      )}
    </nav>
  );
};

export default Navbar;
