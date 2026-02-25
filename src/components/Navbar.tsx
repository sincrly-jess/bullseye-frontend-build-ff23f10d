import bullseyeLogo from "@/assets/bullseye-logo.png";
import { Menu, Bell } from "lucide-react";

interface NavbarProps {
  onMenuToggle: () => void;
}

const Navbar = ({ onMenuToggle }: NavbarProps) => {
  return (
    <nav className="fixed top-0 left-0 right-0 z-50 glass border-b border-border">
      <div className="container mx-auto flex items-center justify-between h-14 px-4">
        {/* Left: Hamburger + Bell */}
        <div className="flex items-center gap-3">
          <button
            onClick={onMenuToggle}
            className="p-2 text-muted-foreground hover:text-foreground transition-colors"
          >
            <Menu className="w-5 h-5" />
          </button>
          <button className="p-2 text-muted-foreground hover:text-foreground transition-colors">
            <Bell className="w-5 h-5" />
          </button>
        </div>

        {/* Center: Logo */}
        <img src={bullseyeLogo} alt="Bullseye" className="h-12 object-contain" />

        {/* Right: User */}
        <div className="flex items-center gap-2">
          <span className="text-sm text-muted-foreground hidden sm:inline">testu</span>
          <div className="w-8 h-8 rounded-full bg-muted border border-border overflow-hidden">
            <div className="w-full h-full bg-muted-foreground/30 flex items-center justify-center text-xs text-foreground">
              T
            </div>
          </div>
        </div>
      </div>
    </nav>
  );
};

export default Navbar;
