import { useState, useRef, useEffect } from "react";
import bullseyeLogo from "@/assets/bullseye-logo.png";
import defaultPfp from "@/assets/default-pfp.png";
import { Menu, Bell } from "lucide-react";

interface NavbarProps {
  onMenuToggle: () => void;
}

const profileMenuItems = [
  { label: "View Profile", href: "#" },
  { label: "Friends", href: "#" },
  { label: "Rewards", href: "#" },
  { label: "Chat", href: "#" },
  { label: "Stats", href: "#" },
  { label: "Logout", href: "#" },
];

const Navbar = ({ onMenuToggle }: NavbarProps) => {
  const [profileOpen, setProfileOpen] = useState(false);
  const dropdownRef = useRef<HTMLDivElement>(null);

  useEffect(() => {
    const handleClick = (e: MouseEvent) => {
      if (dropdownRef.current && !dropdownRef.current.contains(e.target as Node)) {
        setProfileOpen(false);
      }
    };
    document.addEventListener("mousedown", handleClick);
    return () => document.removeEventListener("mousedown", handleClick);
  }, []);

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

        {/* Right: User + Dropdown */}
        <div className="relative" ref={dropdownRef}>
          <button
            onClick={() => setProfileOpen(!profileOpen)}
            className="flex items-center gap-2 cursor-pointer"
          >
            <span className="text-sm text-muted-foreground hidden sm:inline">testu</span>
            <img
              src={defaultPfp}
              alt="Profile"
              className="w-8 h-8 rounded-full border border-border object-cover"
            />
          </button>

          {profileOpen && (
            <div className="absolute right-0 top-12 z-[100] w-48 rounded-xl bg-card border border-border shadow-xl p-3 space-y-2">
              {profileMenuItems.map((item) => (
                <a
                  key={item.label}
                  href={item.href}
                  className="block w-full text-center py-2.5 rounded-lg bg-primary text-primary-foreground font-semibold hover:bg-primary/80 transition-colors"
                >
                  {item.label}
                </a>
              ))}
            </div>
          )}
        </div>
      </div>
    </nav>
  );
};

export default Navbar;
